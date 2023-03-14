<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\KwitansiPembayaranController;
use App\Http\Controllers\KartuSppController;
use App\Http\Controllers\WaliNotifikasiController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PanduanPembayaranController;

use App\Http\Controllers\User\WaliController;
use App\Http\Controllers\User\SiswaController;
use App\Http\Controllers\User\BiayaController;
use App\Http\Controllers\User\TagihanController;
use App\Http\Controllers\User\TagihanLainStepController;
use App\Http\Controllers\User\TagihanLainStep2Controller;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\StatusController;
use App\Http\Controllers\User\JobStatusController;
use App\Http\Controllers\User\MigrasiController;
use App\Http\Controllers\User\TagihanUpdateLunas;
use App\Http\Controllers\User\TagihanDestroy;
use App\Http\Controllers\User\SiswaDestroy;
use App\Http\Controllers\User\TagihanLainStep4Controller;
use App\Http\Controllers\User\BankSekolahController;
use App\Http\Controllers\User\BerandaUserController;
use App\Http\Controllers\User\WaliSiswaController;
use App\Http\Controllers\User\UserController;

use App\Http\Controllers\WaliMurid\BerandaWaliController;
use App\Http\Controllers\WaliMurid\WaliMuridSiswaController;
use App\Http\Controllers\WaliMurid\WaliMuridProfilController;
use App\Http\Controllers\WaliMurid\WaliMuridTagihanController;
use App\Http\Controllers\WaliMurid\WaliMuridPembayaranController;

use App\Http\Controllers\KepalaSekolah\LaporanFormController;
use App\Http\Controllers\KepalaSekolah\LaporanPembayaranController;
use App\Http\Controllers\KepalaSekolah\LaporanRekapPembayaran;
use App\Http\Controllers\KepalaSekolah\LaporanTagihanController;
use App\Http\Controllers\KepalaSekolah\LogActivityController;
use App\Http\Controllers\KepalaSekolah\LogVisitorController;
use App\Http\Controllers\KepalaSekolah\SettingController;
use App\Http\Controllers\KepalaSekolah\SettingWhacenterController;

Route::get('login/login-url', [LoginController::class, 'loginUrl'])->name('login.url');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('panduan-pembayaran/{id}', [PanduanPembayaranController::class, 'index'])->name('panduan.pembayaran');

Route::prefix('kepala_sekolah')->middleware(['auth', 'auth.kepalasekolah'])->name('kepala_sekolah.')->group(function () {
    // USER
    Route::get('beranda', [BerandaUserController::class, 'index'])->name('beranda');
    Route::resource('banksekolah', BankSekolahController::class);
    Route::resource('user', UserController::class);
    Route::resource('wali', WaliController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('walisiswa', WaliSiswaController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('tagihanlainstep', TagihanLainStepController::class);
    Route::post('tagihanlainstep2', TagihanLainStep2Controller::class)->name('tagihanlainstep2.store');
    Route::get('tagihanlainstep2', TagihanLainStep2Controller::class)->name('tagihanlainstep2.delete');
    Route::post('tagihanlainstep4', TagihanLainStep4Controller::class)->name('tagihanlainstep4.store');
    Route::post('tagihanupdatelunas', TagihanUpdateLunas::class)->name('tagihanupdate.lunas');
    Route::post('tagihandestory', TagihanDestroy::class)->name('tagihandestory.ajax');

    Route::post('siswadestory', SiswaDestroy::class)->name('siswadestory.ajax');
    Route::resource('migrasiform', MigrasiController::class);
    Route::resource('jobstatus', JobStatusController::class);

    Route::get('delete-biaya-item/{id}', [BiayaController::class, 'deleteItem'])->name('delete-biaya.item');
    Route::get('status/update', [StatusController::class, 'update'])->name('status.update');
    // Route::post('siswaimport', SiswaImportController::class)->name('siswaimport.store');

    // KEPALA SEKOLAH
    Route::resource('settingwhacenter', SettingWhacenterController::class);
    Route::resource('setting', SettingController::class);

    Route::resource('logactivity', LogActivityController::class);
    Route::post('logactivitydestroy', [LogActivityController::class, 'deleteLog'])->name('logactivitydestroy.ajax');
    Route::resource('logvisitor', LogVisitorController::class);
    Route::post('logvisitordestroy', [LogVisitorController::class, 'deleteLog'])->name('logvisitordestroy.ajax');

    Route::get('laporanform/create', [LaporanFormController::class, 'create'])->name('laporanform.create');
    Route::get('laporantagihan', [LaporanTagihanController::class, 'index'])->name('laporantagihan.index');
    Route::get('laporanpembayaran', [LaporanPembayaranController::class, 'index'])->name('laporanpembayaran.index');
    Route::get('laporanrekappembayaran', [LaporanRekapPembayaran::class, 'index'])->name('laporanrekappembayaran.index');
});

// \Imtigger\LaravelJobStatus\ProgressController::routes();
Route::prefix('operator')->middleware(['auth', 'auth.operator', 'LogVisits'])->name('operator.')->group(function () {
    // USER
    Route::get('beranda', [BerandaUserController::class, 'index'])->name('beranda');
    Route::resource('banksekolah', BankSekolahController::class);
    Route::resource('user', UserController::class);
    Route::resource('wali', WaliController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('walisiswa', WaliSiswaController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('pembayaran', PembayaranController::class);

    Route::resource('tagihanlainstep', TagihanLainStepController::class);
    Route::post('tagihanlainstep2', TagihanLainStep2Controller::class)->name('tagihanlainstep2.store');
    Route::get('tagihanlainstep2', TagihanLainStep2Controller::class)->name('tagihanlainstep2.delete');
    Route::post('tagihanlainstep4', TagihanLainStep4Controller::class)->name('tagihanlainstep4.store');
    Route::post('tagihanupdatelunas', TagihanUpdateLunas::class)->name('tagihanupdate.lunas');
    Route::post('tagihandestory', TagihanDestroy::class)->name('tagihandestory.ajax');

    Route::post('siswadestory', SiswaDestroy::class)->name('siswadestory.ajax');
    Route::resource('migrasiform', MigrasiController::class);
    Route::resource('jobstatus', JobStatusController::class);

    Route::get('delete-biaya-item/{id}', [BiayaController::class, 'deleteItem'])->name('delete-biaya.item');
    Route::get('status/update', [StatusController::class, 'update'])->name('status.update');
    // Route::post('siswaimport', SiswaImportController::class)->name('siswaimport.store');
});

Route::prefix('walimurid')->middleware(['auth', 'auth.wali', 'LogVisits'])->name('wali.')->group(function () {
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
