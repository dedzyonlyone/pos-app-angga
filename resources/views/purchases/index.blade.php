@extends('layouts.app')
@section('title', 'Stok Masuk')
@section('content')
<div class="card animate-fade-up shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-box-arrow-in-down me-2 text-primary"></i> Riwayat Stok Masuk</h5>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm px-3"><i class="bi bi-plus-lg me-1"></i> Catat Stok Masuk</a>
    </div>
    <div class="card-body p-0">
        @if($purchases->isEmpty())
            <div class="empty-state py-5"><i class="bi bi-inbox text-muted fs-1"></i><p class="mt-2 text-muted">Belum ada riwayat stok masuk.</p></div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-3">No. Dokumen</th><th class="py-3">Tanggal</th><th class="py-3">Supplier</th><th class="py-3">Dicatat Oleh</th><th class="text-end py-3">Total Belanja</th><th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $p)
                            <tr>
                                <td class="px-3"><code>{{ $p->purchase_number }}</code></td>
                                <td>{{ $p->purchase_date->format('d/m/Y') }}</td>
                                <td class="fw-semibold">{{ $p->supplier->name }}</td>
                                <td>{{ $p->user->name }}</td>
                                <td class="text-end fw-semibold">{{ rupiah($p->total_amount) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('purchases.show', $p->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($purchases->hasPages()) <div class="p-3 border-top">{{ $purchases->links('pagination::bootstrap-5') }}</div> @endif
        @endif
    </div>
</div>
@endsection