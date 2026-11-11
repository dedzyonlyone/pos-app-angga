@extends('layouts.app')

@section('title', 'Kasir')

@push('styles')
<style>
    /* Styling khusus halaman kasir */
    .pos-container { height: calc(100vh - 130px); display: flex; gap: 1.5rem; }
    .product-list { flex: 1; overflow-y: auto; }
    .cart-panel { width: 400px; display: flex; flex-direction: column; background: #fff; border-radius: 0.75rem; border: 1px solid #e9ecef; }
    
    /* Card produk di katalog */
    .product-card { cursor: pointer; transition: all 0.2s; border: 1px solid #e9ecef; }
    .product-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-color: var(--pos-primary); }
    .product-card .img-wrapper { height: 100px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 0.5rem 0.5rem 0 0; overflow: hidden; }
    .product-card .img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    
    /* Cart Items */
    .cart-items { flex: 1; overflow-y: auto; padding: 1rem; }
    .cart-item { padding: 0.75rem 0; border-bottom: 1px dashed #dee2e6; }
    
    /* Sembunyikan input number panah */
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
</style>
@endpush

@section('content')
<div class="pos-container animate-fade-up">
    
    <!-- ================= KIRI: KATALOG PRODUK ================= -->
    <div class="product-list d-flex flex-column">
        <!-- Search -->
        <div class="mb-3">
            <input type="text" id="searchProduct" class="form-control form-control-lg shadow-sm" placeholder="Cari nama produk atau scan SKU...">
        </div>
        
        <!-- Grid Produk -->
        <div class="row g-3" id="productGrid">
            @foreach($products as $prod)
                <div class="col-6 col-md-4 col-xl-3 product-item" data-name="{{ strtolower($prod->name) }}" data-sku="{{ strtolower($prod->sku) }}">
                    <div class="card h-100 product-card shadow-sm" onclick="addToCart({{ $prod->id }})">
                        <div class="img-wrapper">
                            @if($prod->image)
                                <img src="{{ asset('storage/' . $prod->image) }}" alt="{{ $prod->name }}">
                            @else
                                <i class="bi bi-box text-muted fs-1"></i>
                            @endif
                        </div>
                        <div class="card-body p-2">
                            <div class="fw-bold text-truncate" title="{{ $prod->name }}" style="font-size: 0.9rem;">{{ $prod->name }}</div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <span class="text-success fw-bold" style="font-size: 0.85rem;">{{ rupiah($prod->selling_price) }}</span>
                                <span class="badge bg-light text-dark border">Stok: {{ $prod->stock }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ================= KANAN: KERANJANG ================= -->
    <div class="cart-panel shadow-sm">
        <div class="p-3 bg-light border-bottom rounded-top">
            <h6 class="mb-0 fw-bold"><i class="bi bi-cart3 me-2 text-primary"></i> Keranjang Belanja</h6>
        </div>
        
        <div class="cart-items" id="cartItems">
            <!-- Item masuk ke sini lewat JS -->
        </div>

        <!-- Form Checkout -->
        <div class="p-3 border-top bg-light rounded-bottom">
            <form action="{{ route('sales.store') }}" method="POST" id="checkoutForm">
                @csrf
                <div id="hiddenInputs"></div>
                
                <div class="mb-2">
                    <select name="customer_id" class="form-select form-select-sm">
                        <option value="">Pelanggan Umum</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <select name="payment_method" id="paymentMethod" class="form-select form-select-sm" required>
                            <option value="tunai">Tunai</option>
                            <option value="qris">QRIS</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="number" name="discount" id="discountInput" class="form-control form-control-sm" placeholder="Diskon (Rp)" min="0" value="0">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-muted small">Subtotal</span>
                    <span class="fw-bold" id="subtotalText">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-4 text-primary" id="totalText">Rp 0</span>
                </div>
                
                <div class="mb-2" id="paidAmountWrapper">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="paid_amount" id="paidInput" class="form-control" placeholder="Uang Diterima" min="0">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small">Kembalian</span>
                    <span class="fw-bold text-danger" id="changeText">Rp 0</span>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" id="btnSubmit" disabled>
                    <i class="bi bi-check-circle me-1"></i> Proses Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data produk dari server ke JS
    const products = @json($products);
    let cart = [];

    // Format Rupiah
    const formatRp = (num) => 'Rp ' + num.toLocaleString('id-ID');

    // Render Keranjang (Dibuat lebih aman)
    function renderCart() {
        const container = document.getElementById('cartItems');
        
        if (cart.length === 0) {
            // Tampilan kalau kosong
            container.innerHTML = `
                <div class="text-center text-muted mt-5" id="emptyCart">
                    <i class="bi bi-basket fs-1 text-secondary opacity-50"></i>
                    <p class="mt-2">Belum ada produk dipilih.</p>
                </div>
            `;
        } else {
            // Tampilan kalau ada isinya
            container.innerHTML = cart.map((item, index) => `
                <div class="cart-item d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 pe-2">
                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">${item.name}</div>
                        <div class="text-muted small">${formatRp(item.price)}</div>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <input type="number" class="form-control form-control-sm text-center" style="width: 50px;" 
                               value="${item.qty}" min="1" max="${item.stock}" 
                               oninput="updateQty(${index}, this.value)">
                        <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeItem(${index})">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        }
        calculateTotals();
    }

    // Tambah ke Keranjang
    function addToCart(id) {
        const product = products.find(p => p.id === id);
        if (!product) return;

        const existing = cart.find(item => item.id === id);

        if (existing) {
            if (existing.qty < product.stock) {
                existing.qty++;
            } else {
                alert(`Stok ${product.name} tidak mencukupi!`);
            }
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.selling_price),
                qty: 1,
                stock: product.stock
            });
        }
        renderCart();
    }

    // Ubah Qty
    function updateQty(index, val) {
        let qty = parseInt(val);
        const item = cart[index];
        
        if (isNaN(qty) || qty < 1) qty = 1;
        if (qty > item.stock) {
            alert(`Maksimal stok ${item.name} adalah ${item.stock}`);
            qty = item.stock;
        }
        
        cart[index].qty = qty;
        calculateTotals(); // Hitung total tanpa render ulang seluruh list
    }

    // Hapus Item
    function removeItem(index) {
        cart.splice(index, 1); // Hapus dari array data
        renderCart(); // Render ulang keranjang dari data terbaru
    }

    // Hitung Total
    function calculateTotals() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const discount = parseFloat(document.getElementById('discountInput').value) || 0;
        const total = Math.max(0, subtotal - discount);
        
        document.getElementById('subtotalText').innerText = formatRp(subtotal);
        document.getElementById('totalText').innerText = formatRp(total);

        // Handle Kembalian & Submit Button
        const method = document.getElementById('paymentMethod').value;
        const paid = parseFloat(document.getElementById('paidInput').value) || 0;
        const change = paid - total;

        if (method === 'tunai') {
            document.getElementById('changeText').innerText = change >= 0 ? formatRp(change) : 'Kurang ' + formatRp(Math.abs(change));
        } else {
            document.getElementById('changeText').innerText = 'Rp 0';
        }

        // Tombol submit aktif hanya jika ada barang & uang cukup (kecuali non-tunai)
        const isValid = cart.length > 0 && (method !== 'tunai' || paid >= total);
        document.getElementById('btnSubmit').disabled = !isValid;

        // Inject hidden inputs untuk form POST
        let hiddenInputs = '';
        cart.forEach((item, i) => {
            hiddenInputs += `<input type="hidden" name="items[${i}][product_id]" value="${item.id}">`;
            hiddenInputs += `<input type="hidden" name="items[${i}][quantity]" value="${item.qty}">`;
        });
        document.getElementById('hiddenInputs').innerHTML = hiddenInputs;
    }

    // Event Listeners
    document.getElementById('discountInput').addEventListener('input', calculateTotals);
    document.getElementById('paidInput').addEventListener('input', calculateTotals);
    
    document.getElementById('paymentMethod').addEventListener('change', function() {
        const wrapper = document.getElementById('paidAmountWrapper');
        const paidInput = document.getElementById('paidInput');

        if (this.value !== 'tunai') {
            wrapper.style.display = 'none';
            paidInput.value = '';
        } else {
            wrapper.style.display = 'block';
        }
        calculateTotals();
    });

    // Search Produk (Sederhana)
    document.getElementById('searchProduct').addEventListener('input', function() {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            const name = item.getAttribute('data-name');
            const sku = item.getAttribute('data-sku');
            if (name.includes(keyword) || sku.includes(keyword)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // ==========================================
    // LOGIKA INTERCEPT FORM (QRIS & TRANSFER)
    // ==========================================
    let timerInterval;

    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const method = document.getElementById('paymentMethod').value;
        
        if (method === 'tunai') {
            return; // Lanjut submit normal
        }

        e.preventDefault(); // Cegat submit untuk non-tunai

        const total = document.getElementById('totalText').innerText;

        if (method === 'qris') {
            Swal.fire({
                title: 'Menunggu Pembayaran',
                html: `
                    <p class="text-muted small mb-2">Silakan scan QRIS di bawah ini</p>
                    <img src="{{ asset('qris.png') }}" alt="QRIS" class="img-fluid border rounded p-2 mb-3" style="max-height: 250px;">
                    <h4 class="fw-bold text-primary mb-3">${total}</h4>
                    <div class="fs-3 fw-bold text-danger mb-2" id="swal-timer">01:00</div>
                    <small class="text-muted">Sisa waktu pembayaran</small>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-circle"></i> Konfirmasi Dibayar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#0f4c5c',
                cancelButtonColor: '#dc3545',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    let timeLeft = 60;
                    const timerEl = document.getElementById('swal-timer');

                    timerInterval = setInterval(() => {
                        timeLeft--;
                        let m = Math.floor(timeLeft / 60);
                        let s = timeLeft % 60;
                        timerEl.innerText = `0${m}:${s < 10 ? '0'+s : s}`;

                        if (timeLeft <= 0) {
                            clearInterval(timerInterval);
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Gagal',
                                text: 'Waktu pembayaran telah habis (Expired). Silakan ulangi transaksi.',
                                confirmButtonColor: '#dc3545',
                            });
                        }
                    }, 1000);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    clearInterval(timerInterval);
                    this.submit();
                }
            });
               } else {
            // Untuk metode Transfer
            Swal.fire({
                title: 'Instruksi Transfer',
                html: `
                    <div class="text-start">
                        <p class="mb-2 small text-muted">Silakan transfer ke rekening berikut:</p>
                        <div class="p-3 bg-light rounded border mb-3 text-center">
                            <div class="fw-bold fs-5 text-dark">Seabank</div>
                            <div class="fs-4 fw-bold text-primary my-1">9015-4112-2999</div>
                            <div class="small text-muted">a.n. Toko Sejahtera</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Total Tagihan:</span>
                            <span class="fw-bold fs-5 text-danger">${total}</span>
                        </div>
                        <p class="small text-muted mb-0">Pastikan nominal transfer sama persis. Klik tombol di bawah jika pelanggan sudah selesai transfer.</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-circle"></i> Uang Sudah Masuk',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#0f4c5c',
                cancelButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika kasir klik konfirmasi, form dikirim ke database
                    this.submit();
                }
            });
        }
    });
</script>
@endpush