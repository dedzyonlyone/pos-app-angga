<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $today = now()->toDateString();

        $baseQuery = Sale::where('status', 'paid')
            ->whereDate('sale_date', $today);

        if (auth()->user()->role === 'kasir') {
            $baseQuery->where('user_id', auth()->id());
        }

        $salesToday = (clone $baseQuery)->sum('total');
        $countToday = (clone $baseQuery)->count();
        $lowStock = Product::whereColumn('stock', '<=', 'min_stock')->count();
        $activeProducts = Product::where('is_active', true)->count();

        $latestSales = Sale::with('customer')
            ->where('status', 'paid')
            ->when(auth()->user()->role === 'kasir', fn ($q) => $q->where('user_id', auth()->id()))
            ->latest('sale_date')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'salesToday', 'countToday', 'lowStock', 'activeProducts', 'latestSales'
        ));
    }
}