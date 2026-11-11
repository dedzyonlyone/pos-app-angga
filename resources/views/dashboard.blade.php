@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Penjualan Hari Ini</div>
                    <div class="stat-value">{{ rupiah($salesToday) }}</div>
                </div>
                <span class="stat-icon"><i class="bi bi-cash-stack"></i></span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Transaksi Hari Ini</div>
                    <div class="stat-value">{{ $countToday }}</div>
                </div>
                <span class="stat-icon"><i class="bi bi-receipt-cutoff"></i></span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Stok Menipis</div>
                    <div class="stat-value">{{ $lowStock }}</div>
                </div>
                <span class="stat-icon"><i class="bi bi-exclamation-triangle"></i></span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Produk Aktif</div>
                    <div class="stat-value">{{ $activeProducts }}</div>
                </div>
                <span class="stat-icon"><i class="bi bi-box-seam"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-1"></i> 5 Transaksi Terakhir</span>
        <a href="#" class="btn btn-sm btn-outline-primary disabled" tabindex="-1">
            Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        @if($latestSales->isEmpty())
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                Belum ada transaksi hari ini.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestSales as $sale)
                            <tr>
                                <td class="fw-semibold">{{ $sale->invoice_number }}</td>
                                <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                                <td>{{ $sale->customer->name ?? 'Umum' }}</td>
                                <td class="text-end text-money">{{ rupiah($sale->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection