@extends('layouts.app')
@section('title', $product->exists ? 'Ubah Produk' : 'Tambah Produk')
@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data"
              action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
            @csrf
            @if($product->exists) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
                    <input name="sku" value="{{ old('sku', $product->sku) }}"
                           class="form-control @error('sku') is-invalid @enderror"
                           placeholder="misal: MNM-001" required>
                    @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                    <input name="name" value="{{ old('name', $product->name) }}"
                           class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                    <input name="unit" value="{{ old('unit', $product->unit ?? 'pcs') }}"
                           class="form-control @error('unit') is-invalid @enderror"
                           placeholder="pcs / kg / box" required>
                    @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Harga Modal <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="purchase_price"
                           value="{{ old('purchase_price', $product->purchase_price) }}"
                           class="form-control @error('purchase_price') is-invalid @enderror" required>
                    @error('purchase_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Harga Jual <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="selling_price"
                           value="{{ old('selling_price', $product->selling_price) }}"
                           class="form-control @error('selling_price') is-invalid @enderror" required>
                    @error('selling_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Min. Stok <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="min_stock"
                           value="{{ old('min_stock', $product->min_stock ?? 5) }}"
                           class="form-control @error('min_stock') is-invalid @enderror" required>
                    @error('min_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Stok {{ $product->exists ? '(otomatis, tidak bisa diubah)' : 'Awal' }}
                        @unless($product->exists)<span class="text-danger">*</span>@endunless
                    </label>
                    <input type="number" min="0" name="stock"
                           value="{{ old('stock', $product->stock ?? 0) }}"
                           class="form-control @error('stock') is-invalid @enderror"
                           {{ $product->exists ? 'readonly' : 'required' }}>
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gambar</label>
                    <input type="file" name="image" accept="image/*"
                           class="form-control @error('image') is-invalid @enderror">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($product->image)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 style="max-height:60px;border-radius:6px">
                            <small class="text-muted">Upload baru untuk mengganti</small>
                        </div>
                    @endif
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" id="aktif"
                               class="form-check-input"
                               @checked(old('is_active', $product->is_active ?? true))>
                        <label for="aktif" class="form-check-label fw-semibold">Aktif</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-light">Batal</a>
                <button class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection