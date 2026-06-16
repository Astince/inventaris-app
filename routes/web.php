<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\MasterDataController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('barang', BarangController::class)->except(['show']);
    Route::get('/barang/preview-kode/{categoryId}', [BarangController::class, 'previewKode'])->name('barang.preview-kode');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    
    // Laporan Barang
    Route::get('/laporan/barang/export-pdf', [LaporanController::class, 'exportBarangPdf'])->name('laporan.barang.pdf');
    Route::get('/laporan/barang/export-excel', [LaporanController::class, 'exportBarangExcel'])->name('laporan.barang.excel');

    // Laporan Stok
    Route::get('/laporan/stok/export-pdf', [LaporanController::class, 'exportStokPdf'])->name('laporan.stok.pdf');
    Route::get('/laporan/stok/export-excel', [LaporanController::class, 'exportStokExcel'])->name('laporan.stok.excel');

    // Laporan Transaksi
    Route::get('/laporan/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
    Route::get('/laporan/transaksi/export-pdf', [LaporanController::class, 'exportTransaksiPdf'])->name('laporan.transaksi.pdf');
    Route::get('/laporan/transaksi/export-excel', [LaporanController::class, 'exportTransaksiExcel'])->name('laporan.transaksi.excel');
    Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('riwayat.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Kelola Akun — bisa diakses semua user (tampilan berbeda per role)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::middleware(['can:superadmin'])->group(function () {
        // Halaman gabungan Kategori + Unit
        Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');
        Route::post('/master-data/kategori', [MasterDataController::class, 'storeKategori'])->name('master-data.kategori.store');
        Route::delete('/master-data/kategori/{kategori}', [MasterDataController::class, 'destroyKategori'])->name('master-data.kategori.destroy');
        Route::post('/master-data/unit', [MasterDataController::class, 'storeUnit'])->name('master-data.unit.store');
        Route::delete('/master-data/unit/{unit}', [MasterDataController::class, 'destroyUnit'])->name('master-data.unit.destroy');

        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/auditlog', [AuditLogController::class, 'index'])->name('auditlog.index');
    });
});

require __DIR__.'/auth.php';