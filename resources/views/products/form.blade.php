<div class="row g-3">
    <div class="col-md-6">
        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku ?? '') }}" required placeholder="Contoh: MNM-001">
        @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-8">
        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label for="unit" class="form-label">Satuan <span class="text-danger">*</span></label>
        <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', $product->unit ?? '') }}" required placeholder="pcs, botol, kg">
        @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="purchase_price" class="form-label">Harga Beli (Modal) <span class="text-danger">*</span></label>
        <input type="number" name="purchase_price" id="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price', $product->purchase_price ?? '') }}" required min="0" step="any">
        @error('purchase_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="selling_price" class="form-label">Harga Jual <span class="text-danger">*</span></label>
        <input type="number" name="selling_price" id="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price', $product->selling_price ?? '') }}" required min="0" step="any">
        @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="stock" class="form-label">Stok Awal {!! isset($product) ? '<small class="text-muted">(Hanya bisa diubah lewat Stok Masuk)</small>' : '<span class="text-danger">*</span>' !!}</label>
        <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock ?? 0) }}" min="0" {{ isset($product) ? 'readonly' : 'required' }}>
        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="min_stock" class="form-label">Batas Minimum Stok <span class="text-danger">*</span></label>
        <input type="number" name="min_stock" id="min_stock" class="form-control @error('min_stock') is-invalid @enderror" value="{{ old('min_stock', $product->min_stock ?? 5) }}" required min="0">
        @error('min_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-8">
        <label for="image" class="form-label">Gambar Produk (Maks 2MB)</label>
        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($product) && $product->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar saat ini" class="rounded" style="height: 60px;">
                <small class="text-muted ms-2">Gambar saat ini (biarkan kosong jika tidak ingin mengubah)</small>
            </div>
        @endif
    </div>

    <div class="col-md-4 d-flex align-items-center">
        <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Status Aktif (Tampil di Kasir)</label>
        </div>
    </div>
</div>

<div class="mt-4 pt-3 border-top">
    <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-save me-1"></i> Simpan Produk
    </button>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
</div>