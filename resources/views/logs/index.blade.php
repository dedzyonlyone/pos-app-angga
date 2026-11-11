@extends('layouts.app')
@section('title', 'Log Aktivitas')
@section('content')
<div class="card animate-fade-up shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-primary"></i> Log Aktivitas Sistem</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th class="px-3 py-3">Waktu</th><th class="py-3">User</th><th class="py-3">Aksi</th><th class="py-3">Tabel</th><th class="py-3">ID Data</th></tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="px-3">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="fw-semibold">{{ $log->user->name ?? 'Sistem' }}</td>
                        <td><span class="badge {{ $log->action === 'create' ? 'text-bg-success' : ($log->action === 'delete' || $log->action === 'void' ? 'text-bg-danger' : 'text-bg-warning') }}">{{ strtoupper($log->action) }}</span></td>
                        <td><code>{{ $log->table_name }}</code></td>
                        <td>#{{ $log->record_id }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada aktivitas.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-3">{{ $logs->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection