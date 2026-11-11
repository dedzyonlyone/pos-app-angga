@extends('layouts.app')
@section('title', 'Detail Pelanggan')
@section('content')
<div class="row justify-content-center animate-fade-up">
    <div class="col-lg-10">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-person-badge me-2 text-primary"></i> Profil Pelanggan</h5>
                <a href="{{ route('customers.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><th width="200">Nama Lengkap</th><td class="fw-bold fs-5">{{ $customer->name }}</td></tr>
                    <tr><th>No. HP</th><td>{{ $customer->phone ?? '-' }}</td></tr>
                    <tr><th>Email</th><td>{{ $customer->email ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $customer->address ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3"><h6 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-primary"></i> 10 Riwayat Belanja Terakhir</h6></div>
            <div class="card-body p-0">
                @if($customer->sales->isEmpty())
                    <div class="p-4 text-center text-muted">Belum ada riwayat transaksi.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-3">Invoice</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3 text-end px-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->sales as $sale)
                                    <tr>
                                        <td class="px-3"><code>{{ $sale->invoice_number }}</code></td>
                                        <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                                        <td class="text-end px-3 fw-semibold text-success">{{ rupiah($sale->total) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection