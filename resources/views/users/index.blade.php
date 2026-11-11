@extends('layouts.app')
@section('title', 'Manajemen User')
@section('content')
<div class="card animate-fade-up shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-people me-2 text-primary"></i> Manajemen User</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm px-3"><i class="bi bi-person-plus me-1"></i> Tambah User</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th class="px-3 py-3">Nama</th><th class="py-3">Email</th><th class="py-3 text-center">Role</th><th class="py-3 text-center">Status</th><th class="py-3 text-center">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td class="px-3 fw-bold">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td class="text-center"><span class="badge {{ $u->role === 'admin' ? 'text-bg-primary' : 'text-bg-info' }}">{{ strtoupper($u->role) }}</span></td>
                        <td class="text-center">
                            @if($u->is_active) <span class="badge text-bg-success">Aktif</span>
                            @else <span class="badge text-bg-danger">Nonaktif</span> @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('users.edit', $u->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                @if($u->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3 border-top">{{ $users->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection