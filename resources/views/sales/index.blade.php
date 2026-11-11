@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')
<div class="card animate-fade-up shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-receipt me-2 text-primary"></i> Riwayat Penjualan</h5>
        <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm px-3"><i class="bi bi-cart-plus me-1"></i> Transaksi Baru</a>
    </div>
    
    <div class="card-body bg-light border-bottom">
        <form method="GET" action="{{ route('sales.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Invoice</label>
                <input type="text" name="invoice" value="{{ request('invoice') }}" class="form-control form-control-sm" placeholder="INV-...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-funnel me-1"></i> Filter</button>
                @if(request()->anyFilled(['start_date', 'end_date', 'invoice']))
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($sales->isEmpty())
            <div class="empty-state py-5"><i class="bi bi-receipt text-muted fs-1"></i><p class="mt-2 text-muted">Belum ada riwayat transaksi.</p></div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-3">Invoice</th><th class="py-3">Tanggal</th><th class="py-3">Pelanggan</th><th class="py-3">Kasir</th><th class="py-3 text-center">Status</th><th class="py-3 text-end">Total</th><th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $s)
                            <tr>
                                <td class="px-3"><code>{{ $s->invoice_number }}</code></td>
                                <td>{{ $s->sale_date->format('d/m/Y H:i') }}</td>
                                <td>{{ $s->customer->name ?? 'Umum' }}</td>
                                <td>{{ $s->user->name }}</td>
                                <td class="text-center">
                                    @if($s->status === 'paid')
                                        <span class="badge text-bg-success">Paid</span>
                                    @else
                                        <span class="badge text-bg-danger">Void</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold text-success">{{ rupiah($s->total) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('sales.show', $s->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($sales->hasPages()) <div class="p-3 border-top">{{ $sales->links('pagination::bootstrap-5') }}</div> @endif
        @endif
    </div>
</div>
@endsection