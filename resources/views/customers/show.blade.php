@extends('layouts.app')
@section('title', $customer->name)
@section('content')

<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h5 class="fw-bold mb-1">{{ $customer->name }}</h5>
                <p class="text-muted mb-1">
                    <i class="bi bi-telephone me-1"></i>{{ $customer->phone ?? '—' }}
                    <span class="mx-2">·</span>
                    <i class="bi bi-envelope me-1"></i>{{ $customer->email ?? '—' }}
                </p>
                <p class="text-muted mb-0">
                    <i class="bi bi-geo-alt me-1"></i>{{ $customer->address ?? '—' }}
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customers.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Ubah
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Riwayat Belanja (20 terakhir)</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th class="amount">Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($customer->sales as $s)
                <tr>
                    <td class="fw-semibold">{{ $s->invoice_number }}</td>
                    <td>{{ $s->sale_date->format('d/m/Y H:i') }}</td>
                    <td class="amount">{{ rupiah($s->total) }}</td>
                    <td>
                        @if($s->status === 'paid')
                            <span class="badge badge-ok">Paid</span>
                        @else
                            <span class="badge badge-void">Void</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        <i class="bi bi-receipt"></i>Pelanggan ini belum pernah bertransaksi.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection