@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="card animate-fade-up shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-box-seam me-2 text-primary"></i> Daftar Produk</h5>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Produk
            </a>
        @endif
    </div>
    
    <div class="card-body bg-light border-bottom">
        <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Nama atau SKU...">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Kategori</label>
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label text-muted small mb-1">Status</label>
                <select name="is_active" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-funnel me-1"></i> Filter</button>
                @if(request()->anyFilled(['search', 'category_id', 'is_active']))
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($products->isEmpty())
            <div class="empty-state animate-fade-up py-5">
                <i class="bi bi-box text-muted" style="font-size: 3rem;"></i>
                <p class="mb-3 text-muted">Belum ada produk yang sesuai dengan kriteria.</p>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary px-4">Tambah Produk Pertama</a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60" class="text-center py-3">No</th>
                            <th width="70" class="text-center py-3">Gambar</th>
                            <th class="py-3">Produk</th>
                            <th class="py-3">Kategori</th>
                            <th class="text-end py-3">Harga Jual</th>
                            <th class="text-center py-3">Stok</th>
                            <th class="text-center py-3">Status</th>
                            <th width="150" class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                            <tr>
                                <td class="text-center text-muted">{{ $products->firstItem() + $index }}</td>
                                <td class="text-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded shadow-sm border" style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="rounded bg-light border d-flex align-items-center justify-content-center mx-auto" style="width: 45px; height: 45px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                    <small class="text-muted"><code>{{ $product->sku }}</code></small>
                                </td>
                                <td><span class="badge text-bg-light border text-dark">{{ $product->category->name }}</span></td>
                                <td class="text-end fw-semibold text-success">{{ rupiah($product->selling_price) }}</td>
                                <td class="text-center">
                                    @if($product->stock <= $product->min_stock)
                                        <span class="badge text-bg-danger rounded-pill px-3" title="Stok menipis">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge text-bg-success bg-opacity-75 rounded-pill px-3">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($product->is_active)
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-3">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle rounded-pill px-3">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm shadow-sm">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($products->hasPages())
                <div class="p-3 border-top d-flex justify-content-between align-items-center bg-white">
                    <small class="text-muted">Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} produk</small>
                    <div class="m-0">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection