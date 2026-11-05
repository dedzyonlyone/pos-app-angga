@extends('layouts.app')
@section('title', 'Pelanggan')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
    <form class="d-flex gap-2" method="GET">
        <input name="search" value="{{ $q }}" class="form-control"
               placeholder="Cari nama atau nomor HP...">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
        @if($q)
            <a href="{{ route('customers.index') }}" class="btn btn-light">Reset</a>
        @endif
    </form>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pelanggan
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th class="text-center" style="width:120px">Transaksi</th>
                    <th class="text-end" style="width:150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($customers as $c)
                <tr>
                    <td class="fw-semibold">{{ $c->name }}</td>
                    <td>{{ $c->phone ?? '—' }}</td>
                    <td>{{ $c->email ?? '—' }}</td>
                    <td class="text-muted small">{{ \Illuminate\Support\Str::limit($c->address, 40) ?: '—' }}</td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border">{{ $c->sales_count }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('customers.show', $c) }}"
                           class="btn btn-sm btn-outline-secondary" title="Lihat & Riwayat">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('customers.edit', $c) }}"
                           class="btn btn-sm btn-outline-primary" title="Ubah">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if(auth()->user()->role === 'admin')
                            <form action="{{ route('customers.destroy', $c) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus pelanggan {{ $c->name }}? Riwayat transaksi tetap tersimpan.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <i class="bi bi-people"></i>
                        @if($q)
                            Tidak ada pelanggan yang cocok dengan "{{ $q }}".
                        @else
                            Belum ada pelanggan. Tambah pelanggan pertama.
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">
        Menampilkan {{ $customers->firstItem() ?? 0 }}–{{ $customers->lastItem() ?? 0 }}
        dari {{ $customers->total() }} pelanggan
    </small>
    {{ $customers->links() }}
</div>

@endsection