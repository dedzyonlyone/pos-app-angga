<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->string('product_name', 150);
            $table->decimal('price', 15, 2);
            $table->decimal('purchase_price', 15, 2);
            $table->integer('quantity')->unsigned();
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

        public function void(Request $request, Sale $sale)
    {
        // 1. Cek Hak Akses (Hanya Admin)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa membatalkan transaksi.');
        }

        // 2. Cek Status Transaksi
        if ($sale->status === 'void') {
            return back()->with('error', 'Transaksi ini sudah dibatalkan sebelumnya.');
        }

        // 3. Validasi Alasan
        $request->validate([
            'void_reason' => ['required', 'string', 'max:255']
        ]);

        try {
            // 4. Proses Database Transaction
            DB::transaction(function () use ($sale, $request) {
                // a. Ubah status jadi void & simpan alasan
                $sale->update([
                    'status' => 'void',
                    'void_reason' => $request->void_reason
                ]);

                // b. Kembalikan stok produk
                foreach ($sale->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        // Kembalikan stok sesuai jumlah yang dibeli
                        $product->increment('stock', $item->quantity);
                    }
                }
            });

            return redirect()->route('sales.show', $sale->id)->with('success', 'Transaksi berhasil di-void dan stok telah dikembalikan.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
};