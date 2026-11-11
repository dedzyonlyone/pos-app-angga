@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center animate-fade-up">
    <div class="col-lg-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i> Form Edit Produk: {{ $product->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('products.form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection