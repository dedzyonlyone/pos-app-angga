<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $today = now()->toDateString();
        $isKasir = $user->role === 'kasir';

        $todaySales = Sale::whereDate('sale_date', $today)->where('status','paid');
        if ($isKasir) $todaySales->where('user_id', $user->id);

        $cards = [
            'penjualan_hari_ini' => (clone $todaySales)->sum('total'),
            'transaksi_hari_ini' => (clone $todaySales)->count(),
            'stok_menipis'       => Product::lowStock()->active()->count(),
            'produk_aktif'       => Product::active()->count(),
        ];

        $recentSales = Sale::with('user','customer')
            ->when($isKasir, fn($q) => $q->where('user_id', $user->id))
            ->latest('sale_date')->limit(5)->get();

        return view('dashboard', compact('cards','recentSales'));
    }
}