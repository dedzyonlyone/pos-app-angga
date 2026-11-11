<div class="mb-3">
    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
    <input type="text" 
           name="name" 
           id="name" 
           class="form-control @error('name') is-invalid @enderror" 
           value="{{ old('name', $category->name ?? '') }}" 
           required 
           autofocus>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea name="description" 
              id="description" 
              rows="3" 
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4 pt-3 border-top">
    <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-save me-1"></i> Simpan
    </button>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
</div>