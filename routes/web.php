<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

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

    // === SUDAH JADI ===
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);

    // === SEMENTARA (closure) ===
    Route::get('/sales', fn() => 'Riwayat Transaksi — segera hadir')->name('sales.index');
    Route::get('/sales/create', fn() => 'Kasir — segera hadir')->name('sales.create');
    Route::get('/sales/{sale}', fn($sale) => 'Detail #'.$sale)->name('sales.show');
    Route::get('/sales/{sale}/receipt', fn($sale) => 'Struk #'.$sale)->name('sales.receipt');
    Route::post('/sales/{sale}/void', fn($sale) => back())->name('sales.void');

    Route::get('/profile/password', fn() => 'Ubah Password — segera hadir')->name('profile.password');
    Route::put('/profile/password', fn() => back())->name('profile.password.update');

    Route::get('/suppliers', fn() => 'Supplier — segera hadir')->name('suppliers.index');
    Route::get('/suppliers/create', fn() => 'Tambah Supplier — segera hadir')->name('suppliers.create');
    Route::post('/suppliers', fn() => back())->name('suppliers.store');
    Route::get('/suppliers/{supplier}/edit', fn($supplier) => 'Edit #'.$supplier)->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', fn($supplier) => back())->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', fn($supplier) => back())->name('suppliers.destroy');

    Route::get('/purchases', fn() => 'Stok Masuk — segera hadir')->name('purchases.index');
    Route::get('/purchases/create', fn() => 'Tambah Stok Masuk — segera hadir')->name('purchases.create');
    Route::post('/purchases', fn() => back())->name('purchases.store');
    Route::get('/purchases/{purchase}', fn($purchase) => 'Detail #'.$purchase)->name('purchases.show');

    Route::get('/reports', fn() => 'Laporan — segera hadir')->name('reports.index');

    Route::get('/users', fn() => 'Manajemen User — segera hadir')->name('users.index');
    Route::get('/users/create', fn() => 'Tambah User — segera hadir')->name('users.create');
    Route::post('/users', fn() => back())->name('users.store');
    Route::get('/users/{user}/edit', fn($user) => 'Edit #'.$user)->name('users.edit');
    Route::put('/users/{user}', fn($user) => back())->name('users.update');
    Route::delete('/users/{user}', fn($user) => back())->name('users.destroy');

    Route::get('/settings', fn() => 'Pengaturan — segera hadir')->name('settings.index');
    Route::put('/settings', fn() => back())->name('settings.update');
});