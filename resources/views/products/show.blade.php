@extends('layouts.app')
@section('title', $product->name)
@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                         style="height:220px">
                        <i class="bi bi-box text-muted" style="font-size:3rem"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
                <p class="text-muted mb-3">
                    <code>{{ $product->sku }}</code> · {{ $product->category->name }} · {{ $product->unit }}
                </p>

                <table class="table table-sm">
                    <tr><th width="200">Harga Modal</th><td class="amount">{{ rupiah($product->purchase_price) }}</td></tr>
                    <tr><th>Harga Jual</th><td class="amount">{{ rupiah($product->selling_price) }}</td></tr>
                    <tr><th>Stok Saat Ini</th>
                        <td>
                            {{ $product->stock }} {{ $product->unit }}
                            @if($product->stock <= $product->min_stock)
                                <span class="badge badge-low ms-1">Stok Menipis</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Min. Stok</th><td>{{ $product->min_stock }}</td></tr>
                    <tr><th>Status</th>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-ok">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Ubah
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection