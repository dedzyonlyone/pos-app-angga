@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
<div class="row justify-content-center animate-fade-up"><div class="col-lg-8"><div class="card shadow-sm">
    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold text-dark">Form User Baru</h5></div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">@csrf @include('users.form')</form>
    </div>
</div></div></div>
@endsection