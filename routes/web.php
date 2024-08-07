<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TahunKegiatanController;
use App\Http\Controllers\TimKegiatanController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'preventBackHistory'], function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login', [LoginController::class, 'show'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::get('/', function() {
            return redirect(route('login'));
        });
    });
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::prefix('admin')->name('admin.')->middleware(['userAccess:Admin'])->group(function() {
            route::get('/dashboard', [LoginController::class, 'adminDashboard'])->name('dashboard');
            route::get('/data/tahun_kegiatan', [TahunKegiatanController::class, 'showDataTahun'])->name('show.data_tahun_kegiatan');
            route::post('/data/tahun_kegiatan/create', [TahunKegiatanController::class, 'createDataTahun'])->name('create.data_tahun_kegiatan');
            route::put('/data/tahun_kegiatan/{TahunKegiatan}/edit', [TahunKegiatanController::class, 'editDataTahun'])->name('edit.data_tahun_kegiatan');
            route::delete('/data/tahun_kegiatan/{TahunKegiatan}/delete', [TahunKegiatanController::class, 'deleteDataTahun'])->name('delete.data_tahun_kegiatan');
            route::get('/data/tahun_kegiatan/{tahun?}/tim_kegiatan', [TimKegiatanController::class, 'showDataTim'])->name('show.data_tim_kegiatan');
            route::post('/data/tahun_kegiatan/{tahun?}/tim_kegiatan/create', [TimKegiatanController::class, 'createDataTim'])->name('create.data_tim_kegiatan');
            route::put('/data/tahun_kegiatan/{tahun?}/tim_kegiatan/{nama}/edit', [TimKegiatanController::class, 'editDataTim'])->name('edit.data_tim_kegiatan');
            route::delete('/data/tahun_kegiatan/{tahun?}/tim_kegiatan/{nama}/delete', [TimKegiatanController::class, 'deleteDataTim'])->name('delete.data_tim_kegiatan');
            route::get('/data/tahun_kegiatan/{tahun?}/tim_kegiatan/{nama}/detail', [TimKegiatanController::class, 'showDetailTim'])->name('show.detail_tim_kegiatan');
            route::post('/data/tahun_kegiatan/{tahun?}/tim_kegiatan/{nama}/anggota/create', [TimKegiatanController::class, 'createAnggotaTim'])->name('create.anggota_tim');
            route::put('/data/tahun_kegiatan/{tahun?}/tim_kegiatan/{nama}/anggota/edit', [TimKegiatanController::class, 'editAnggotaTim'])->name('edit.data_anggota_tim');
            route::delete('/data/tahun_kegiatan/{tahun?}/tim_kegiatan/{nama}/anggota/delete', [TimKegiatanController::class, 'deleteAnggotaTim'])->name('delete.data_anggota_tim');
        });
        Route::prefix('ketua')->name('ketua.')->middleware(['userAccess:Ketua'])->group(function() {
            route::get('/homepage', [LoginController::class, 'userHomepage'])->name('homepage');
        });
        Route::prefix('anggota')->name('anggota.')->middleware(['userAccess:Anggota'])->group(function() {
            route::get('/homepage', [LoginController::class, 'userHomepage'])->name('homepage');
        });
    });
});
