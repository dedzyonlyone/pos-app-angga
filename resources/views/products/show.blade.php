@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="row justify-content-center animate-fade-up">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-info-circle me-1"></i> Detail Produk</span>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="150">Nama Produk</th>
                                <td class="fw-bold fs-5">{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>SKU</th>
                                <td><code>{{ $product->sku }}</code></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $product->category->name }}</td>
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <td>{{ rupiah($product->purchase_price) }}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td class="text-success fw-bold">{{ rupiah($product->selling_price) }}</td>
                            </tr>
                            <tr>
                                <th>Stok Saat Ini</th>
                                <td>
                                    <span class="badge {{ $product->stock <= $product->min_stock ? 'text-bg-danger' : 'text-bg-success' }} fs-6">
                                        {{ $product->stock }} {{ $product->unit }}
                                    </span>
                                    @if($product->stock <= $product->min_stock)
                                        <small class="text-danger ms-2"><i class="bi bi-exclamation-triangle"></i> Stok Menipis</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Batas Minimum Stok</th>
                                <td>{{ $product->min_stock }} {{ $product->unit }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge text-bg-primary">Aktif</span>
                                    @else
                                        <span class="badge text-bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection