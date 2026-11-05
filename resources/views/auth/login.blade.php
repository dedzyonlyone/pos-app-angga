@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="auth-card">
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3"
             style="width:64px;height:64px;background:#eef2ff;color:#1e3a8a">
            <i class="bi bi-shop" style="font-size:1.75rem"></i>
        </div>
        <h4 class="fw-bold mb-1">Masuk ke POS</h4>
        <p class="text-muted small mb-0">Silakan login untuk melanjutkan</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold small">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="admin@pos.test" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold small">Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="••••••••" required>
        </div>
        <button class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </button>
    </form>
</div>
@endsection