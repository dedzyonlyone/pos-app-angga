@extends('layouts.app')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="row justify-content-center animate-fade-up">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-shop me-2 text-primary"></i> Profil & Pengaturan Toko</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf 
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Toko <span class="text-danger">*</span></label>
                        <input type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror" value="{{ old('store_name', $settings['store_name']) }}" required>
                        @error('store_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Toko <span class="text-danger">*</span></label>
                        <textarea name="store_address" rows="2" class="form-control @error('store_address') is-invalid @enderror" required>{{ old('store_address', $settings['store_address']) }}</textarea>
                        @error('store_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telp <span class="text-danger">*</span></label>
                        <input type="text" name="store_phone" class="form-control @error('store_phone') is-invalid @enderror" value="{{ old('store_phone', $settings['store_phone']) }}" required>
                        @error('store_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Footer Struk</label>
                        <small class="text-muted d-block mb-1">Tulisan penutup yang muncul di bagian bawah struk kasir (misal: Terima kasih atas kunjungan Anda).</small>
                        <input type="text" name="receipt_footer" class="form-control @error('receipt_footer') is-invalid @enderror" value="{{ old('receipt_footer', $settings['receipt_footer']) }}">
                        @error('receipt_footer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection