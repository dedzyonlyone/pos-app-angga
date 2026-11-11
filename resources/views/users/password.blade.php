@extends('layouts.app')
@section('title', 'Ubah Password')
@section('content')
<div class="row justify-content-center animate-fade-up">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold text-dark">Ubah Password Saya</h5></div>
            <div class="card-body">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary px-4 w-100">Simpan Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection