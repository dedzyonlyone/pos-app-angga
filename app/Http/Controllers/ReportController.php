<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [ new Middleware('role:admin') ];
    }

    public function index(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $baseQuery = Sale::where('status', 'paid')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate);

        $summary = (clone $baseQuery)->selectRaw('
            SUM(total) as total_revenue, COUNT(*) as total_transactions,
            AVG(total) as avg_transaction, SUM(discount) as total_discount
        ')->first();

        $dailySales = (clone $baseQuery)->selectRaw('DATE(sale_date) as date, COUNT(*) as transactions, SUM(total) as revenue')
            ->groupBy('date')->orderBy('date', 'desc')->get();

        $topProducts = SaleItem::whereHas('sale', function($q) use ($startDate, $endDate) {
                $q->where('status', 'paid')->whereDate('sale_date', '>=', $startDate)->whereDate('sale_date', '<=', $endDate);
            })->select('product_id', 'product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_id', 'product_name')->orderByDesc('total_qty')->limit(10)->get();

        $profit = SaleItem::whereHas('sale', function($q) use ($startDate, $endDate) {
                $q->where('status', 'paid')->whereDate('sale_date', '>=', $startDate)->whereDate('sale_date', '<=', $endDate);
            })->selectRaw('SUM((price - purchase_price) * quantity) as gross_profit')->first();

        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->where('is_active', true)->orderBy('stock', 'asc')->limit(10)->get();

        return view('reports.index', compact('startDate', 'endDate', 'summary', 'dailySales', 'topProducts', 'profit', 'lowStockProducts'));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();
        return Excel::download(new SalesExport($startDate, $endDate), 'Laporan_Penjualan_' . $startDate . '_sd_' . $endDate . '.xlsx');
    }
}