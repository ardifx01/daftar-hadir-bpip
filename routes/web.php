<?php

use App\Http\Controllers\be\AdminDaftarHadirController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\be\RoleController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\be\PesertaController;
use App\Http\Controllers\be\KegiatanController;
use App\Http\Controllers\MstKegiatanController;
use App\Http\Controllers\be\DashboardController;
use App\Http\Controllers\be\NarasumberController;
use App\Http\Controllers\be\DaftarHadirController;
use App\Http\Controllers\fe\IsiKehadiranController;
use App\Http\Controllers\fe\SuccessController;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Frontend
Route::get('/',  [BerandaController::class, 'index'])->name('beranda');
Route::get('/lembar/{slug}', [BerandaController::class, 'lembar']); //  Routing Link
Route::get('/cari/{kode_kegiatan}',  [BerandaController::class, 'cari']); // Cari by Kode kegiatan

Route::get('/create-daftar-hadir-internal/{kode_kegiatan}', [BerandaController::class, 'create_internal']); //  Routing Link
Route::get('/create-daftar-hadir-eksternal/{kode_kegiatan}', [BerandaController::class, 'create_eksternal']); //  Routing Link

Route::get('/cari', function () {
    return view('frontend.cari');
});
Route::get('/blank', function () {
    return view('frontend.blank');
});

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/login/sso', [UserController::class, 'login'])->name('loginsso');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    // Admin
    Route::get('/mst-kegiatan', [MstKegiatanController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan-create');
    Route::get('/kegiatan/edit/{id}', [KegiatanController::class, 'edit'])->name('kegiatan-edit');
    Route::get('/kegiatan/cetak/{id}', [KegiatanController::class, 'cetak'])->name('kegiatan-cetak');
    Route::put('/kegiatan/update/{id}', [KegiatanController::class, 'update'])->name('kegiatan-update');
    Route::post('/kegiatan/destroy', [KegiatanController::class, 'destroy'])->name('kegiatan-destroy');
    Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('kegiatan-store');
    Route::get('/narasumber', [NarasumberController::class, 'index'])->name('narasumber');

    Route::get('/kegiatan/list_peserta/{id}', [KegiatanController::class, 'list_peserta'])->name('kegiatan-list-peserta');

    //listDaftarHadir
    Route::get('/list-daftar-hadir', [DaftarHadirController::class, 'index'])->name('list-daftar-hadir');

    // Admin DaftarHadir
    Route::get('/admin-dashboard', [AdminDaftarHadirController::class, 'index'])->name('admin-daftar-hadir.index');
    Route::get('/admin-list-all/{param?}', [AdminDaftarHadirController::class, 'list_all'])->name('admin-daftar-hadir.list-all');
    //Route::get('/peserta-eksternal', [PesertaController::class, 'index']);
    //Route::get('/role', [RoleController::class, 'index']);
});

// untuk isi kehadiran
Route::get('/isi-kehadiran/{slug}', [IsiKehadiranController::class, 'index'])->name('isi-kehadiran');
Route::get('/isi-kehadiran/{slug}/form', [IsiKehadiranController::class, 'form'])->name('isi-kehadiran-form');
Route::post('/isi-kehadiran/store', [IsiKehadiranController::class, 'store'])->name('isi-kehadiran-store');
Route::get('/success', [SuccessController::class, 'index'])->name('success');

Route::get('/akses_umum/daftar_hadir/index/{slug}', function ($slug) {
    $url = env('URL_DAFTAR_HADIR_OLD') . '/akses_umum/daftar_hadir/index/' . $slug;
    return redirect()->away($url);
});
