<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::with(['customer', 'user'])
            ->when(auth()->user()->role === 'kasir', fn ($query) => $query->where('user_id', auth()->id()))
            ->when($request->start_date, fn($q, $val) => $q->whereDate('sale_date', '>=', $val))
            ->when($request->end_date, fn($q, $val) => $q->whereDate('sale_date', '<=', $val))
            ->when($request->invoice, fn($q, $val) => $q->where('invoice_number', 'like', "%{$val}%"))
            ->latest('sale_date')->paginate(15)->withQueryString();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::with('category')->where('is_active', true)->where('stock', '>', 0)->orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        return view('sales.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['nullable', 'exists:customers,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:tunai,qris,transfer'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $sale = DB::transaction(function () use ($validated) {
                $productIds = collect($validated['items'])->pluck('product_id');
                $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');
                $subtotal = 0;

                foreach ($validated['items'] as $index => $item) {
                    $product = $products[$item['product_id']];
                    if ($product->stock < $item['quantity']) {
                        throw ValidationException::withMessages(["items.{$index}.quantity" => "Stok {$product->name} tidak cukup (sisa: {$product->stock})."]);
                    }
                    $subtotal += $product->selling_price * $item['quantity'];
                }

                $discount = $validated['discount'] ?? 0;
                if ($discount > $subtotal) throw ValidationException::withMessages(['discount' => 'Diskon melebihi subtotal.']);

                $total = $subtotal - $discount;
                $paidAmount = $validated['payment_method'] === 'tunai' ? ($validated['paid_amount'] ?? 0) : $total;
                
                if ($paidAmount < $total) throw ValidationException::withMessages(['paid_amount' => 'Uang bayar kurang.']);

                $changeAmount = $paidAmount - $total;
                $date = now()->format('Ymd');
                $prefix = "INV-{$date}-";
                $lastSale = Sale::where('invoice_number', 'like', $prefix . '%')->orderBy('invoice_number', 'desc')->first();
                $sequence = $lastSale ? (int) substr($lastSale->invoice_number, -4) + 1 : 1;
                $invoiceNumber = $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);

                $sale = Sale::create([
                    'invoice_number' => $invoiceNumber, 'user_id' => auth()->id(),
                    'customer_id' => $validated['customer_id'] ?? null, 'sale_date' => now(),
                    'subtotal' => $subtotal, 'discount' => $discount, 'total' => $total,
                    'payment_method' => $validated['payment_method'], 'paid_amount' => $paidAmount,
                    'change_amount' => $changeAmount, 'status' => 'paid', 'note' => $validated['note'] ?? null,
                ]);

                foreach ($validated['items'] as $item) {
                    $product = $products[$item['product_id']];
                    $sale->items()->create([
                        'product_id' => $product->id, 'product_name' => $product->name,
                        'price' => $product->selling_price, 'purchase_price' => $product->purchase_price,
                        'quantity' => $item['quantity'], 'subtotal' => $product->selling_price * $item['quantity'],
                    ]);
                    $product->decrement('stock', $item['quantity']);
                }

                ActivityLogger::log('create', 'sales', $sale->id, null, $sale->toArray());
                return $sale;
            });

            return redirect()->route('sales.show', $sale->id)->with('success', 'Transaksi berhasil!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Sale $sale)
    {
        if (auth()->user()->role === 'kasir' && $sale->user_id !== auth()->id()) abort(403, 'Akses ditolak.');
        $sale->load(['items.product', 'customer', 'user']);
        return view('sales.show', compact('sale'));
    }

    public function void(Request $request, Sale $sale)
    {
        if (auth()->user()->role !== 'admin') abort(403, 'Hanya admin yang bisa membatalkan transaksi.');
        if ($sale->status === 'void') return back()->with('error', 'Transaksi sudah dibatalkan sebelumnya.');

        $request->validate(['void_reason' => ['required', 'string', 'max:255']]);

        try {
            DB::transaction(function () use ($sale, $request) {
                $oldData = $sale->toArray();
                $sale->update(['status' => 'void', 'void_reason' => $request->void_reason]);

                foreach ($sale->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) $product->increment('stock', $item->quantity);
                }
                ActivityLogger::log('void', 'sales', $sale->id, $oldData, $sale->fresh()->toArray());
            });
            return redirect()->route('sales.show', $sale->id)->with('success', 'Transaksi berhasil di-void dan stok telah dikembalikan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}