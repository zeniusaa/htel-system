<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // =========================
    // DASHBOARD
    // =========================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/arsip/selesai',
        [DashboardController::class, 'arsipSelesai']
    )->name('arsip.selesai');


    // =========================
    // PENGAJUAN — PPAT
    // =========================

    Route::get('/pengajuan', [PengajuanController::class, 'index'])
        ->name('pengajuan.index');

    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])
        ->name('pengajuan.create');

    Route::post('/pengajuan', [PengajuanController::class, 'store'])
        ->name('pengajuan.store');

    Route::post(
        '/pengajuan/{id}/upload-dokumen',
        [PengajuanController::class, 'uploadDokumen']
    )->name('pengajuan.uploadDokumen');

    Route::post(
        '/pengajuan/{id}/ajukan',
        [PengajuanController::class, 'ajukan']
    )->name('pengajuan.ajukan');

    Route::delete(
        '/pengajuan/dokumen/{dokumen}',
        [PengajuanController::class, 'hapusDokumen']
    )->name('pengajuan.hapusDokumen');

    Route::delete(
        '/pengajuan/{id}',
        [PengajuanController::class, 'destroy']
    )->name('pengajuan.destroy');

    Route::get(
        '/pengajuan/{id}/edit',
        [PengajuanController::class, 'edit']
    )->name('pengajuan.edit');

    Route::put(
        '/pengajuan/{id}',
        [PengajuanController::class, 'update']
    )->name('pengajuan.update');

    // DETAIL harus di bawah
    Route::get(
        '/pengajuan/{id}',
        [PengajuanController::class, 'show']
    )->name('pengajuan.show');

    Route::post(
        '/pengajuan/{id}/upload-bukti-bayar',
        [PengajuanController::class, 'uploadBuktiBayar']
    )->name('pengajuan.uploadBuktiBayar');

    Route::post('/pengajuan/{id}/selesai', 
        [PengajuanController::class, 'selesai']
    )->name('pengajuan.selesai');


    // =========================
    // BANK
    // =========================

    Route::get(
        '/bank/pengajuan/{pengajuan}',
        [PengajuanController::class, 'showBank']
    )->name('bank.pengajuan.show');

    Route::post(
    '/bank/pengajuan/{id}/update-status',
        [PengajuanController::class, 'updateStatus']
    )->name('bank.pengajuan.updateStatus');

    Route::post('/bank/pengajuan/{pengajuan}/upload-sps',
        [PengajuanController::class, 'uploadSps']
    )->name('bank.pengajuan.uploadSps');

    Route::post('/bank/pengajuan/{pengajuan}/upload-sht',
        [PengajuanController::class, 'uploadSht']
    )->name('bank.pengajuan.uploadSht');

    Route::post('/bank/pengajuan/{pengajuan}/generate-lamp13',
        [PengajuanController::class, 'generateLamp13']
    )->name('bank.generateLamp13');

    Route::delete('/bank/pengajuan/{pengajuan}/hapus-lamp13',
        [PengajuanController::class, 'hapusLamp13']
    )->name('bank.hapusLamp13');

    Route::get('/bank/{pengajuan}/download-zip',
        [PengajuanController::class, 'downloadZip'])
    ->name('bank.downloadZip');

    Route::get('/pengajuan/{pengajuan}/download-sht',
        [PengajuanController::class, 'downloadSht']
    )->name('pengajuan.downloadSht');

    // =========================
    // PROFILE
    // =========================

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__ . '/auth.php';