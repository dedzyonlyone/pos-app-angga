@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row g-3 mb-3">
    @php
    $stat = [
        ['label'=>'Penjualan Hari Ini','value'=>rupiah($cards['penjualan_hari_ini']),'icon'=>'cash-coin','color'=>'#10b981','bg'=>'#d1fae5'],
        ['label'=>'Transaksi Hari Ini','value'=>$cards['transaksi_hari_ini'],'icon'=>'receipt','color'=>'#3b82f6','bg'=>'#dbeafe'],
        ['label'=>'Produk Stok Menipis','value'=>$cards['stok_menipis'],'icon'=>'exclamation-triangle','color'=>'#f59e0b','bg'=>'#fef3c7'],
        ['label'=>'Produk Aktif','value'=>$cards['produk_aktif'],'icon'=>'box-seam','color'=>'#8b5cf6','bg'=>'#ede9fe'],
    ];
    @endphp
    @foreach($stat as $s)
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $s['bg'] }};color:{{ $s['color'] }}">
                <i class="bi bi-{{ $s['icon'] }}"></i>
            </div>
            <div>
                <div class="stat-label">{{ $s['label'] }}</div>
                <div class="stat-value">{{ $s['value'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>5 Transaksi Terakhir</span>
        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-primary">Lihat semua</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Invoice</th><th>Tanggal</th><th>Kasir</th><th>Pelanggan</th><th class="amount">Total</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($recentSales as $s)
                <tr>
                    <td><a href="{{ route('sales.show',$s) }}" class="text-decoration-none fw-semibold">{{ $s->invoice_number }}</a></td>
                    <td>{{ $s->sale_date->format('d/m/Y H:i') }}</td>
                    <td>{{ $s->user->name }}</td>
                    <td>{{ $s->customer->name ?? 'Umum' }}</td>
                    <td class="amount">{{ rupiah($s->total) }}</td>
                    <td>{!! $s->status === 'paid' ? '<span class="badge badge-ok">Paid</span>' : '<span class="badge badge-void">Void</span>' !!}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection