@extends('layouts.app')
@section('title', 'Tambah Supplier')
@section('content')
<div class="row justify-content-center animate-fade-up"><div class="col-lg-8"><div class="card shadow-sm">
    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold text-dark">Form Supplier Baru</h5></div>
    <div class="card-body">
        <form action="{{ route('suppliers.store') }}" method="POST">@csrf @include('suppliers.form')</form>
    </div>
</div></div></div>
@endsection