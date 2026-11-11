@extends('layouts.app')
@section('title', 'Catat Stok Masuk')
@section('content')
<div class="card animate-fade-up shadow-sm">
    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold text-dark">Form Stok Masuk</h5></div>
    <div class="card-body">
        <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Supplier <span class="text-danger">*</span></label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $sup) <option value="{{ $sup->id }}">{{ $sup->name }}</option> @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                    <input type="date" name="purchase_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <h6 class="fw-bold mb-3 border-bottom pb-2">Daftar Produk</h6>
            
            <div class="table-responsive mb-3">
                <table class="table table-bordered align-middle" id="itemsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th width="120">Jumlah</th>
                            <th width="180">Harga Beli (Rp)</th>
                            <th width="180" class="text-end">Subtotal</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <!-- Baris pertama -->
                        <tr>
                            <td>
                                <select name="items[0][product_id]" class="form-select product-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $prd) 
                                        <option value="{{ $prd->id }}" data-price="{{ $prd->purchase_price }}">{{ $prd->name }} ({{ $prd->sku }})</option> 
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="items[0][quantity]" class="form-control qty-input" value="1" min="1" required></td>
                            <td><input type="number" name="items[0][purchase_price]" class="form-control price-input" value="0" min="0" required></td>
                            <td class="text-end fw-semibold subtotal-text">Rp 0</td>
                            <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-x"></i></button></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Belanja:</td>
                            <td class="text-end fw-bold fs-5 text-primary" id="grandTotal">Rp 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button type="button" class="btn btn-sm btn-outline-primary mb-4" id="addRow"><i class="bi bi-plus-lg me-1"></i> Tambah Baris</button>

            <div class="mb-4">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="note" rows="2" class="form-control" placeholder="Opsional..."></textarea>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Stok Masuk</button>
                <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let rowIndex = 1;
    const productsData = @json($products);

    function formatRupiah(angka) {
        return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
    }

    function calculateTotals() {
        let grandTotal = 0;
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const subtotal = qty * price;
            
            row.querySelector('.subtotal-text').innerText = formatRupiah(subtotal);
            grandTotal += subtotal;
        });
        document.getElementById('grandTotal').innerText = formatRupiah(grandTotal);
    }

    document.getElementById('addRow').addEventListener('click', function() {
        let options = '<option value="">-- Pilih Produk --</option>';
        productsData.forEach(p => {
            options += `<option value="${p.id}" data-price="${p.purchase_price}">${p.name} (${p.sku})</option>`;
        });

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><select name="items[${rowIndex}][product_id]" class="form-select product-select" required>${options}</select></td>
            <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control qty-input" value="1" min="1" required></td>
            <td><input type="number" name="items[${rowIndex}][purchase_price]" class="form-control price-input" value="0" min="0" required></td>
            <td class="text-end fw-semibold subtotal-text">Rp 0</td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-x"></i></button></td>
        `;
        document.getElementById('itemsBody').appendChild(tr);
        rowIndex++;
    });

    document.getElementById('itemsBody').addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const rows = document.querySelectorAll('#itemsBody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                calculateTotals();
            } else {
                alert('Minimal harus ada 1 produk.');
            }
        }
    });

    document.getElementById('itemsBody').addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const price = e.target.options[e.target.selectedIndex].getAttribute('data-price');
            const row = e.target.closest('tr');
            if (price) {
                row.querySelector('.price-input').value = price;
            }
            calculateTotals();
        }
    });

    document.getElementById('itemsBody').addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input') || e.target.classList.contains('price-input')) {
            calculateTotals();
        }
    });

    // Initialize
    calculateTotals();
</script>
@endpush