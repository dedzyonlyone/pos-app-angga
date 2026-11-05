@extends('layouts.app')
@section('title', $customer->exists ? 'Ubah Pelanggan' : 'Tambah Pelanggan')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST"
                      action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}">
                    @csrf
                    @if($customer->exists) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                            <input name="name" value="{{ old('name', $customer->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   maxlength="100" required autofocus>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input name="phone" value="{{ old('phone', $customer->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="08123456789" maxlength="20">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Opsional. Format: 08xx, 10–13 digit.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   maxlength="150">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="address" rows="3" maxlength="500"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Opsional">{{ old('address', $customer->address) }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('customers.index') }}" class="btn btn-light">Batal</a>
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