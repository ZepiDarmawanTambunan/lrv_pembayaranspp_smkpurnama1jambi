<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BerandaOperatorController;
use App\Http\Controllers\BerandaWaliController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TagihanBiayaLainController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KwitansiPembayaranController;
use App\Http\Controllers\KartuSppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WaliSiswaController;
use App\Http\Controllers\WaliMuridSiswaController;
use App\Http\Controllers\WaliMuridProfilController;
use App\Http\Controllers\WaliMuridTagihanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WaliMuridPembayaranController;
use App\Http\Controllers\WaliNotifikasiController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PanduanPembayaranController;
use App\Http\Controllers\LaporanFormController;
use App\Http\Controllers\LaporanTagihanController;
use App\Http\Controllers\LaporanPembayaranController;
use App\Http\Controllers\LaporanRekapPembayaran;
use App\Http\Controllers\MigrasiController;
use App\Http\Controllers\TagihanUpdateLunas;
use App\Http\Controllers\SettingWhacenterController;
use App\Http\Controllers\TagihanDestroy;
use App\Http\Controllers\SiswaDestroy;

Route::get('login/login-url', [LoginController::class, 'loginUrl'])->name('login.url');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('panduan-pembayaran/{id}', [PanduanPembayaranController::class, 'index'])->name('panduan.pembayaran');

Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {
    Route::get('beranda', [BerandaOperatorController::class, 'index'])->name('operator.beranda');
    Route::resource('banksekolah', BankSekolahController::class);
    Route::resource('settingwhacenter', SettingWhacenterController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('user', UserController::class);
    Route::resource('wali', WaliController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('walisiswa', WaliSiswaController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('tagihanlain', TagihanBiayaLainController::class);

    Route::get('delete-biaya-item/{id}', [BiayaController::class, 'deleteItem'])->name('delete-biaya.item');
    Route::get('status/update', [StatusController::class, 'update'])->name('status.update');

    Route::get('laporanform/create', [LaporanFormController::class, 'create'])->name('laporanform.create');
    Route::get('laporantagihan', [LaporanTagihanController::class, 'index'])->name('laporantagihan.index');
    Route::get('laporanpembayaran', [LaporanPembayaranController::class, 'index'])->name('laporanpembayaran.index');
    Route::get('laporanrekappembayaran', [LaporanRekapPembayaran::class, 'index'])->name('laporanrekappembayaran.index');

    Route::post('tagihanupdatelunas', TagihanUpdateLunas::class)->name('tagihanupdate.lunas');
    Route::post('tagihandestory', TagihanDestroy::class)->name('tagihandestory.ajax');
    Route::post('siswadestory', SiswaDestroy::class)->name('siswadestory.ajax');
    Route::resource('migrasiform', MigrasiController::class);
    // Route::post('siswaimport', SiswaImportController::class)->name('siswaimport.store');
});

Route::prefix('walimurid')->middleware(['auth', 'auth.wali'])->name('wali.')->group(function () {
    Route::get('beranda', [BerandaWaliController::class, 'index'])->name('beranda');
    Route::resource('profil', WaliMuridProfilController::class);
    Route::resource('siswa', WaliMuridSiswaController::class);
    Route::resource('tagihan', WaliMuridTagihanController::class);
    Route::resource('pembayaran', WaliMuridPembayaranController::class);
    Route::resource('notifikasi', WaliNotifikasiController::class);
});

Route::get('kartuspp', [KartuSppController::class, 'index'])->middleware('auth')->name('kartuspp.index');
Route::get('kwitansi-pembayaran/{id}', [KwitansiPembayaranController::class, 'show'])->middleware('auth')->name('kwitansipembayaran.show');
Route::resource('invoice', InvoiceController::class)->middleware('auth');

Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
