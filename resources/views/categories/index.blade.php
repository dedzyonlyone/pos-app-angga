@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-tags me-1"></i> Daftar Kategori</span>
        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>
    
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('categories.index') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nama kategori...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
                @if(request('search'))
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($categories->isEmpty())
            <div class="empty-state">
                <i class="bi bi-tags"></i>
                <p class="mb-2">Belum ada kategori.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Tambah Kategori Pertama</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Jumlah Produk</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $index => $category)
                            <tr>
                                <td class="text-center">{{ $categories->firstItem() + $index }}</td>
                                <td class="fw-semibold">{{ $category->name }}</td>
                                <td>{{ $category->description ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge text-bg-secondary">{{ $category->products_count }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection