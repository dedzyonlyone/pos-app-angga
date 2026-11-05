@extends('layouts.app')
@section('title', 'Kategori')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
    <form class="d-flex gap-2" method="GET">
        <input name="search" value="{{ $q }}" class="form-control" placeholder="Cari kategori...">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
        @if($q)
            <a href="{{ route('categories.index') }}" class="btn btn-light">Reset</a>
        @endif
    </form>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:60px">#</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th class="text-center" style="width:130px">Jumlah Produk</th>
                    <th class="text-end" style="width:140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $c)
                <tr>
                    <td class="text-muted">{{ $categories->firstItem() + $loop->index }}</td>
                    <td class="fw-semibold">{{ $c->name }}</td>
                    <td class="text-muted">{{ $c->description ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border">{{ $c->products_count }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('categories.edit', $c) }}" class="btn btn-sm btn-outline-primary" title="Ubah">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $c) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus kategori {{ $c->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-state">
                        <i class="bi bi-tags"></i>
                        @if($q)
                            Tidak ada kategori yang cocok dengan "{{ $q }}".
                        @else
                            Belum ada kategori. Tambah kategori pertama.
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">
        Menampilkan {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }}
        dari {{ $categories->total() }} kategori
    </small>
    {{ $categories->links() }}
</div>

@endsection