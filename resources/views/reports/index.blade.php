@extends('layouts.app')
@section('title', 'Laporan Penjualan')
@section('content')
<div class="animate-fade-up">
    <div class="card shadow-sm mb-4">
        <div class="card-body bg-light">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label text-muted small mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="form-control form-control-sm">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i> Tampilkan</button>
                    <a href="{{ route('reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-success ms-2">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card stat-card h-100 border-0 shadow-sm bg-primary text-white" style="background: linear-gradient(135deg, #0f4c5c, #1a738a) !important;"><div class="stat-label text-white-50">Total Omzet</div><div class="stat-value text-white">{{ rupiah($summary->total_revenue ?? 0) }}</div></div></div>
        <div class="col-md-3"><div class="card stat-card h-100 border-0 shadow-sm bg-success text-white" style="background: linear-gradient(135deg, #198754, #20c997) !important;"><div class="stat-label text-white-50">Laba Kotor</div><div class="stat-value text-white">{{ rupiah($profit->gross_profit ?? 0) }}</div></div></div>
        <div class="col-md-3"><div class="card stat-card h-100 border-0 shadow-sm"><div class="stat-label">Jumlah Transaksi</div><div class="stat-value text-dark">{{ $summary->total_transactions ?? 0 }}</div><small class="text-muted">Rata-rata: {{ rupiah($summary->avg_transaction ?? 0) }}</small></div></div>
        <div class="col-md-3"><div class="card stat-card h-100 border-0 shadow-sm"><div class="stat-label">Total Diskon</div><div class="stat-value text-danger">{{ rupiah($summary->total_discount ?? 0) }}</div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3"><h6 class="mb-0 fw-bold"><i class="bi bi-calendar-check me-2 text-primary"></i> Penjualan Harian</h6></div>
                <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="table-light sticky-top"><tr><th class="px-3 py-2">Tanggal</th><th class="text-center py-2">Transaksi</th><th class="text-end px-3 py-2">Omzet</th></tr></thead>
                        <tbody>
                            @forelse($dailySales as $ds)
                                <tr><td class="px-3">{{ \Carbon\Carbon::parse($ds->date)->format('d/m/Y') }}</td><td class="text-center">{{ $ds->transactions }}</td><td class="text-end px-3 fw-semibold text-success">{{ rupiah($ds->revenue) }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3"><h6 class="mb-0 fw-bold"><i class="bi bi-star me-2 text-warning"></i> 10 Produk Terlaris</h6></div>
                <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="table-light sticky-top"><tr><th class="px-3 py-2">Produk</th><th class="text-center py-2">Terjual</th><th class="text-end px-3 py-2">Omzet</th></tr></thead>
                        <tbody>
                            @forelse($topProducts as $tp)
                                <tr><td class="px-3 fw-semibold">{{ $tp->product_name }}</td><td class="text-center"><span class="badge text-bg-secondary">{{ $tp->total_qty }}</span></td><td class="text-end px-3">{{ rupiah($tp->total_revenue) }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger bg-opacity-10 py-3 border-danger-subtle"><h6 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle me-2"></i> Peringatan Stok Menipis</h6></div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th class="px-3">SKU</th><th>Nama Produk</th><th class="text-center">Sisa Stok</th><th class="text-center">Batas Min.</th></tr></thead>
                        <tbody>
                            @forelse($lowStockProducts as $ls)
                                <tr><td class="px-3"><code>{{ $ls->sku }}</code></td><td class="fw-semibold">{{ $ls->name }}</td><td class="text-center fw-bold text-danger">{{ $ls->stock }}</td><td class="text-center">{{ $ls->min_stock }}</td></tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Semua stok aman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection