@extends('layouts.app')
@section('title', 'Edit Supplier')
@section('content')
<div class="row justify-content-center animate-fade-up"><div class="col-lg-8"><div class="card shadow-sm">
    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold text-dark">Edit Supplier: {{ $supplier->name }}</h5></div>
    <div class="card-body">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">@csrf @method('PUT') @include('suppliers.form')</form>
    </div>
</div></div></div>
@endsection