<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')->name('login.attempt');
});

// Auth
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');

    // Route sementara untuk menu yang belum ada controller-nya.
    // Nanti akan diganti saat modul terkait dikerjakan.
    Route::get('/sales', fn() => 'Halaman Riwayat Transaksi — segera hadir')->name('sales.index');
    Route::get('/sales/create', fn() => 'Halaman Kasir — segera hadir')->name('sales.create');
    Route::get('/sales/{sale}', fn($sale) => 'Detail transaksi #'.$sale)->name('sales.show');
    Route::get('/sales/{sale}/receipt', fn($sale) => 'Struk #'.$sale)->name('sales.receipt');
    Route::post('/sales/{sale}/void', fn($sale) => back())->name('sales.void');

    Route::get('/profile/password', fn() => 'Ubah Password — segera hadir')->name('profile.password');
    Route::put('/profile/password', fn() => back())->name('profile.password.update');

    Route::get('/categories', fn() => 'Kategori — segera hadir')->name('categories.index');
    Route::get('/categories/create', fn() => 'Tambah Kategori — segera hadir')->name('categories.create');
    Route::post('/categories', fn() => back())->name('categories.store');
    Route::get('/categories/{category}/edit', fn($category) => 'Edit Kategori #'.$category)->name('categories.edit');
    Route::put('/categories/{category}', fn($category) => back())->name('categories.update');
    Route::delete('/categories/{category}', fn($category) => back())->name('categories.destroy');

    Route::get('/products', fn() => 'Produk — segera hadir')->name('products.index');
    Route::get('/products/create', fn() => 'Tambah Produk — segera hadir')->name('products.create');
    Route::post('/products', fn() => back())->name('products.store');
    Route::get('/products/{product}', fn($product) => 'Detail Produk #'.$product)->name('products.show');
    Route::get('/products/{product}/edit', fn($product) => 'Edit Produk #'.$product)->name('products.edit');
    Route::put('/products/{product}', fn($product) => back())->name('products.update');
    Route::delete('/products/{product}', fn($product) => back())->name('products.destroy');

    Route::get('/customers', fn() => 'Pelanggan — segera hadir')->name('customers.index');
    Route::get('/customers/create', fn() => 'Tambah Pelanggan — segera hadir')->name('customers.create');
    Route::post('/customers', fn() => back())->name('customers.store');
    Route::get('/customers/{customer}', fn($customer) => 'Detail Pelanggan #'.$customer)->name('customers.show');
    Route::get('/customers/{customer}/edit', fn($customer) => 'Edit Pelanggan #'.$customer)->name('customers.edit');
    Route::put('/customers/{customer}', fn($customer) => back())->name('customers.update');
    Route::delete('/customers/{customer}', fn($customer) => back())->name('customers.destroy');

    Route::get('/suppliers', fn() => 'Supplier — segera hadir')->name('suppliers.index');
    Route::get('/suppliers/create', fn() => 'Tambah Supplier — segera hadir')->name('suppliers.create');
    Route::post('/suppliers', fn() => back())->name('suppliers.store');
    Route::get('/suppliers/{supplier}/edit', fn($supplier) => 'Edit Supplier #'.$supplier)->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', fn($supplier) => back())->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', fn($supplier) => back())->name('suppliers.destroy');

    Route::get('/purchases', fn() => 'Stok Masuk — segera hadir')->name('purchases.index');
    Route::get('/purchases/create', fn() => 'Tambah Stok Masuk — segera hadir')->name('purchases.create');
    Route::post('/purchases', fn() => back())->name('purchases.store');
    Route::get('/purchases/{purchase}', fn($purchase) => 'Detail Stok Masuk #'.$purchase)->name('purchases.show');

    Route::get('/reports', fn() => 'Laporan — segera hadir')->name('reports.index');

    Route::get('/users', fn() => 'Manajemen User — segera hadir')->name('users.index');
    Route::get('/users/create', fn() => 'Tambah User — segera hadir')->name('users.create');
    Route::post('/users', fn() => back())->name('users.store');
    Route::get('/users/{user}/edit', fn($user) => 'Edit User #'.$user)->name('users.edit');
    Route::put('/users/{user}', fn($user) => back())->name('users.update');
    Route::delete('/users/{user}', fn($user) => back())->name('users.destroy');

    Route::get('/settings', fn() => 'Pengaturan — segera hadir')->name('settings.index');
    Route::put('/settings', fn() => back())->name('settings.update');
});