@extends('layouts.app')
@section('title', $category->exists ? 'Ubah Kategori' : 'Tambah Kategori')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">

                <form method="POST"
                      action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
                    @csrf
                    @if($category->exists)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                        <input name="name" value="{{ old('name', $category->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               maxlength="100" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <input name="description" value="{{ old('description', $category->description) }}"
                               class="form-control @error('description') is-invalid @enderror"
                               maxlength="255" placeholder="Opsional, misal: minuman dingin & panas">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('categories.index') }}" class="btn btn-light">Batal</a>
                        <button class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection