<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Support\DocumentNumber;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin'),
        ];
    }

    public function index()
    {
        $purchases = Purchase::with(['supplier', 'user'])
            ->latest('purchase_date')
            ->paginate(10);

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchase_date' => ['required', 'date', 'before_or_equal:today'],
            'note' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.purchase_price' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $purchaseNumber = DocumentNumber::generatePurchaseNumber();
                $totalAmount = 0;

                // 1. Simpan Header
                $purchase = Purchase::create([
                    'purchase_number' => $purchaseNumber,
                    'supplier_id' => $validated['supplier_id'],
                    'user_id' => auth()->id(),
                    'purchase_date' => $validated['purchase_date'],
                    'note' => $validated['note'] ?? null,
                    'total_amount' => 0,
                ]);

                // 2. Simpan Item & Update Stok
                foreach ($validated['items'] as $item) {
                    $subtotal = $item['quantity'] * $item['purchase_price'];
                    $totalAmount += $subtotal;

                    $purchase->items()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'purchase_price' => $item['purchase_price'],
                        'subtotal' => $subtotal,
                    ]);

                    // Update stok dan harga beli terbaru
                    $product = Product::findOrFail($item['product_id']);
                    $product->increment('stock', $item['quantity']);
                    $product->update(['purchase_price' => $item['purchase_price']]);
                }

                // 3. Update total di header
                $purchase->update(['total_amount' => $totalAmount]);
            });

            return redirect()->route('purchases.index')->with('success', 'Stok masuk berhasil disimpan dan stok produk telah diperbarui.');

        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['items.product', 'supplier', 'user']);
        return view('purchases.show', compact('purchase'));
    }
}