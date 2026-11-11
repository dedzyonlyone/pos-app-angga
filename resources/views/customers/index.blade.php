@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="card animate-fade-up shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-people me-2 text-primary"></i> Data Pelanggan</h5>
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pelanggan
        </a>
    </div>
    
    <div class="card-body bg-light border-bottom">
        <form method="GET" action="{{ route('customers.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Nama atau No. HP...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-search me-1"></i> Cari</button>
                @if(request('search'))
                    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($customers->isEmpty())
            <div class="empty-state py-5">
                <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                <p class="mb-3 text-muted">Belum ada data pelanggan.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center py-3">No</th>
                            <th class="py-3">Nama</th>
                            <th class="py-3">No. HP</th>
                            <th class="py-3">Email</th>
                            <th class="text-center py-3">Total Transaksi</th>
                            <th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $index => $c)
                            <tr>
                                <td class="text-center text-muted">{{ $customers->firstItem() + $index }}</td>
                                <td class="fw-bold">{{ $c->name }}</td>
                                <td>{{ $c->phone ?? '-' }}</td>
                                <td>{{ $c->email ?? '-' }}</td>
                                <td class="text-center"><span class="badge text-bg-secondary">{{ $c->sales_count }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm shadow-sm">
                                        <a href="{{ route('customers.show', $c->id) }}" class="btn btn-outline-secondary" title="Lihat"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('customers.edit', $c->id) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                        @if(auth()->user()->role === 'admin')
                                            <form action="{{ route('customers.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pelanggan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($customers->hasPages())
                <div class="p-3 border-top">{{ $customers->links('pagination::bootstrap-5') }}</div>
            @endif
        @endif
    </div>
</div>
@endsection