@extends('layouts.app')
@section('title', 'Data Supplier')
@section('content')
<div class="card animate-fade-up shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-truck me-2 text-primary"></i> Data Supplier</h5>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm px-3"><i class="bi bi-plus-lg me-1"></i> Tambah Supplier</a>
    </div>
    <div class="card-body bg-light border-bottom">
        <form method="GET" action="{{ route('suppliers.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nama supplier...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-search me-1"></i> Cari</button>
                @if(request('search')) <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a> @endif
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        @if($suppliers->isEmpty())
            <div class="empty-state py-5"><i class="bi bi-truck text-muted fs-1"></i><p class="mt-2 text-muted">Belum ada supplier.</p></div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center py-3">No</th><th class="py-3">Nama Supplier</th><th class="py-3">Contact Person</th><th class="py-3">No. Telp</th><th class="text-center py-3">Total Stok Masuk</th><th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $index => $s)
                            <tr>
                                <td class="text-center text-muted">{{ $suppliers->firstItem() + $index }}</td>
                                <td class="fw-bold">{{ $s->name }}</td>
                                <td>{{ $s->contact_person ?? '-' }}</td>
                                <td>{{ $s->phone }}</td>
                                <td class="text-center"><span class="badge text-bg-secondary">{{ $s->purchases_count }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm shadow-sm">
                                        <a href="{{ route('suppliers.edit', $s->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus supplier ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($suppliers->hasPages()) <div class="p-3 border-top">{{ $suppliers->links('pagination::bootstrap-5') }}</div> @endif
        @endif
    </div>
</div>
@endsection