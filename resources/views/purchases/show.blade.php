@extends('layouts.app')
@section('title', 'Detail Stok Masuk')
@section('content')
<div class="row justify-content-center animate-fade-up">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Dokumen: {{ $purchase->purchase_number }}</h5>
                <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <table class="table table-sm table-borderless">
                            <tr><th width="120">Supplier</th><td>: {{ $purchase->supplier->name }}</td></tr>
                            <tr><th>Tanggal</th><td>: {{ $purchase->purchase_date->format('d F Y') }}</td></tr>
                        </table>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <table class="table table-sm table-borderless">
                            <tr><th width="120">Dicatat Oleh</th><td>: {{ $purchase->user->name }}</td></tr>
                            <tr><th>Waktu Input</th><td>: {{ $purchase->created_at->format('d/m/Y H:i') }}</td></tr>
                        </table>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th><th>Nama Produk</th><th>SKU</th><th class="text-center">Qty</th><th class="text-end">Harga Beli</th><th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchase->items as $idx => $item)
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td><code>{{ $item->product->sku }}</code></td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ rupiah($item->purchase_price) }}</td>
                                    <td class="text-end">{{ rupiah($item->subtotal) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total Belanja:</th>
                                <th class="text-end text-primary fs-5">{{ rupiah($purchase->total_amount) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($purchase->note)
                    <div class="alert alert-info py-2"><strong>Catatan:</strong> {{ $purchase->note }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection