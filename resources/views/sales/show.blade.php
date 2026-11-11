@extends('layouts.app')

@section('title', 'Detail Transaksi')

@push('styles')
<style>
    /* CSS Khusus Print */
    @media print {
        .sidebar, .topbar, .no-print { display: none !important; }
        .main-area { margin: 0 !important; padding: 0 !important; }
        .content { padding: 0 !important; }
        .app-shell { display: block !important; }
        .receipt-box { box-shadow: none !important; border: none !important; width: 100% !important; max-width: 80mm !important; margin: 0 auto !important; }
        body { background: #fff !important; font-size: 12px !important; }
    }
    
    /* Styling Tanda VOID */
    .void-stamp {
        border: 3px solid #dc3545;
        color: #dc3545;
        display: inline-block;
        padding: 5px 20px;
        font-weight: 800;
        font-size: 1.5rem;
        transform: rotate(-10deg);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center animate-fade-up">
    <div class="col-lg-8">
        
        <!-- Tombol Aksi (Bagian Atas) -->
        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            
            <div>
                <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer-fill me-1"></i> Cetak Struk</button>
                
                <!-- Tombol Void (Hanya muncul untuk admin & status masih paid) -->
                @if(auth()->user()->role === 'admin' && $sale->status === 'paid')
                    <form action="{{ route('sales.void', $sale->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan (VOID) transaksi ini? Stok akan dikembalikan.');">
                        @csrf
                        <input type="hidden" name="void_reason" value="Dibatalkan oleh admin via sistem">
                        <button type="submit" class="btn btn-danger ms-2"><i class="bi bi-x-circle me-1"></i> Void Transaksi</button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Kotak Struk -->
        <div class="card shadow-sm receipt-box mx-auto" style="max-width: 400px;">
            <div class="card-body p-4">
                
                <!-- Tanda VOID (Hanya muncul jika status void) -->
                @if($sale->status === 'void')
                    <div class="text-center mb-3">
                        <div class="void-stamp">VOID / BATAL</div>
                        <br>
                        <small class="text-danger fw-bold">Alasan: {{ $sale->void_reason }}</small>
                    </div>
                    <hr class="my-2">
                @endif

                <!-- Header Toko -->
                <div class="text-center mb-3 border-bottom pb-3">
                    <h5 class="fw-bold mb-1">{{ \App\Models\Setting::get('store_name', 'POS App') }}</h5>
                    <p class="text-muted small mb-1">{{ \App\Models\Setting::get('store_address') }}</p>
                    <p class="text-muted small mb-0">Telp: {{ \App\Models\Setting::get('store_phone') }}</p>
                </div>

                <!-- Info Transaksi -->
                <div class="mb-3 small">
                    <div class="d-flex justify-content-between"><span>No. Invoice</span><span class="fw-bold">{{ $sale->invoice_number }}</span></div>
                    <div class="d-flex justify-content-between"><span>Tanggal</span><span>{{ $sale->sale_date->format('d/m/Y H:i') }}</span></div>
                    <div class="d-flex justify-content-between"><span>Kasir</span><span>{{ $sale->user->name }}</span></div>
                    <div class="d-flex justify-content-between"><span>Pelanggan</span><span>{{ $sale->customer->name ?? 'Umum' }}</span></div>
                </div>

                <!-- List Item -->
                <div class="border-top border-bottom py-2 mb-3">
                    @foreach($sale->items as $item)
                        <div class="mb-2">
                            <div class="fw-semibold">{{ $item->product_name }}</div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>{{ $item->quantity }} x {{ rupiah($item->price) }}</span>
                                <span>{{ rupiah($item->subtotal) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Ringkasan -->
                <div class="small mb-3">
                    <div class="d-flex justify-content-between"><span>Subtotal</span><span>{{ rupiah($sale->subtotal) }}</span></div>
                    @if($sale->discount > 0)
                        <div class="d-flex justify-content-between text-danger"><span>Diskon</span><span>-{{ rupiah($sale->discount) }}</span></div>
                    @endif
                    <div class="d-flex justify-content-between fw-bold fs-5 mt-2"><span>Total</span><span>{{ rupiah($sale->total) }}</span></div>
                    <div class="d-flex justify-content-between mt-1"><span>Bayar ({{ strtoupper($sale->payment_method) }})</span><span>{{ rupiah($sale->paid_amount) }}</span></div>
                    <div class="d-flex justify-content-between"><span>Kembalian</span><span>{{ rupiah($sale->change_amount) }}</span></div>
                </div>

                <!-- Footer -->
                <div class="text-center small text-muted mt-4">
                    <p class="mb-0">{{ \App\Models\Setting::get('receipt_footer', 'Terima kasih') }}</p>
                    <p class="mb-0 mt-2" style="font-size: 10px;">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection