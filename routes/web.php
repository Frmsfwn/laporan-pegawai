<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TahunKegiatanController;
use App\Http\Controllers\TimKegiatanController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'preventBackHistory'], function(){
    Route::group(['middleware' => 'guest'], function(){

        // Login Function for Guest User
        Route::get('/login', [LoginController::class, 'show'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::get('/', function() {
            return redirect(route('login'));
        });

    });
    Route::group(['middleware' => 'auth'], function(){

        // Logout Function for Authenticated User
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        // Change Password Function
        Route::get('/password/edit', [LoginController::class, 'editPassword'])->name('edit.password');
        Route::put('{User}/password/update', [LoginController::class, 'updatePassword'])->name('update.password');

        Route::prefix('admin')->name('admin.')->middleware(['userAccess:Admin'])->group(function() {

            // Data Tahun (Create-Read-Update-Delete-Search)
            route::get('/homepage', [LoginController::class, 'homepage'])->name('homepage');
            Route::get('/homepage/search', [LoginController::class, 'homepage'])->name('search.data_tahun');
            route::post('/data/tahun/create', [TahunKegiatanController::class, 'createDataTahun'])->name('create.data_tahun');
            route::put('/data/tahun/{TahunKegiatan}/edit', [TahunKegiatanController::class, 'editDataTahun'])->name('edit.data_tahun');
            route::delete('/data/tahun/{TahunKegiatan}/delete', [TahunKegiatanController::class, 'deleteDataTahun'])->name('delete.data_tahun');

            // Data Tim (Create-Read-Update-Delete-Search)
            route::get('/data/tahun/{tahun}/tim', [TimKegiatanController::class, 'showDataTim'])->name('show.data_tim');
            route::get('/data/tahun/{tahun}/tim/search', [TimKegiatanController::class, 'showDataTim'])->name('search.data_tim');
            route::post('/data/tahun/{tahun}/tim/create', [TimKegiatanController::class, 'createDataTim'])->name('create.data_tim');
            route::put('/data/tim/{TimKegiatan}/edit', [TimKegiatanController::class, 'editDataTim'])->name('edit.data_tim');
            route::delete('/data/tim/{TimKegiatan}/delete', [TimKegiatanController::class, 'deleteDataTim'])->name('delete.data_tim');

            // Data Anggota Tim (Create-Read-Update-Delete-Search)
            route::get('/data/tahun/{tahun}/tim/{nama}/anggota', [TimKegiatanController::class, 'showDataAnggota'])->name('show.data_anggota');
            route::get('/data/tahun/{tahun}/tim/{nama}/anggota/search', [TimKegiatanController::class, 'showDataAnggota'])->name('search.data_anggota');
            route::post('/data/tahun/{tahun}/tim/{nama}/anggota/create', [TimKegiatanController::class, 'createDataAnggota'])->name('create.data_anggota');
            route::put('/data/anggota/{AnggotaTim}/edit', [TimKegiatanController::class, 'editDataAnggota'])->name('edit.data_anggota');
            route::delete('/data/anggota/{AnggotaTim}/delete', [TimKegiatanController::class, 'deleteDataAnggota'])->name('delete.data_anggota');

            // Data Laporan Tim (Read-Search)
            route::get('/data/tahun/{tahun}/tim/{nama}/laporan', [TimKegiatanController::class, 'showDataLaporan'])->name('show.data_laporan');
            route::get('/data/tahun/{tahun}/tim/{nama}/laporan/search', [TimKegiatanController::class, 'showDataLaporan'])->name('search.data_laporan');

        });
        Route::prefix('manajemen')->name('manajemen.')->middleware(['userAccess:Manajemen'])->group(function() {

            // Data Tahun (Read)
            route::get('/homepage', [LoginController::class, 'Homepage'])->name('homepage');

            // Data Tim (Read-Search)
            route::get('/data/tahun/{tahun}/tim', [TimKegiatanController::class, 'showDataTim'])->name('show.data_tim');
            route::get('/data/tahun/{tahun}/tim/search', [TimKegiatanController::class, 'showDataTim'])->name('search.data_tim');
            
            // Data Laporan Tim (Read-Search-Accept-Decline)
            route::get('/data/tahun/{tahun}/tim/{nama}/laporan', [TimKegiatanController::class, 'showDataLaporan'])->name('show.data_laporan');
            route::get('/data/tahun/{tahun}/tim/{nama}/laporan/search', [TimKegiatanController::class, 'showDataLaporan'])->name('search.data_laporan');
            route::get('/data/laporan/{LaporanKegiatan}/accept', [TimKegiatanController::class, 'acceptLaporan'])->name('accept.laporan_kegiatan');
            route::post('/data/laporan/{LaporanKegiatan}/decline', [TimKegiatanController::class, 'declineLaporan'])->name('decline.laporan_kegiatan');
            
        });    
        Route::prefix('ketua')->name('ketua.')->middleware(['userAccess:Ketua'])->group(function() {

            // Data Tim (Read)
            route::get('/homepage', [LoginController::class, 'Homepage'])->name('homepage');
            
            // Data Anggota (Read-Search)
            route::get('/data/tahun/{tahun}/tim/{nama}/anggota', [TimKegiatanController::class, 'showDataAnggota'])->name('show.data_anggota');
            route::get('/data/tahun/{tahun}/tim/{nama}/anggota/search', [TimKegiatanController::class, 'showDataAnggota'])->name('search.data_anggota');
            
            // Data Laporan (Create-Read-Update-Delete-Search)
            route::get('/data/tahun/{tahun}/tim/{nama}/laporan', [TimKegiatanController::class, 'showDataLaporan'])->name('show.data_laporan');
            route::get('/data/tahun/{tahun}/tim/{nama}/laporan/search', [TimKegiatanController::class, 'showDataLaporan'])->name('search.data_laporan');
            route::post('/data/tahun/{tahun}/tim/{nama}/laporan/create', [TimKegiatanController::class, 'createLaporanKegiatan'])->name('create.laporan_kegiatan');
            route::put('/data/laporan/{LaporanKegiatan}/edit', [TimKegiatanController::class, 'editLaporanKegiatan'])->name('edit.laporan_kegiatan');
            route::delete('/data/laporan/{LaporanKegiatan}/delete', [TimKegiatanController::class, 'deleteLaporanKegiatan'])->name('delete.laporan_kegiatan');

        });
        Route::prefix('anggota')->name('anggota.')->middleware(['userAccess:Anggota'])->group(function() {

            // Data Tim (Read)
            route::get('/homepage', [LoginController::class, 'Homepage'])->name('homepage');

            // Data Anggota (Read-Search)
            route::get('/data/tahun/{tahun}/tim/{nama}/anggota', [TimKegiatanController::class, 'showDataAnggota'])->name('show.data_anggota');
            route::get('/data/tahun/{tahun}/tim/{nama}/anggota/search', [TimKegiatanController::class, 'showDataAnggota'])->name('search.data_anggota');
            
            // Data Laporan (Update-Read-Search)
            route::get('/data/tahun/{tahun}/tim/{nama}/laporan', [TimKegiatanController::class, 'showDataLaporan'])->name('show.data_laporan');
            route::get('/data/tahun/{tahun}/tim/{nama}/laporan/search', [TimKegiatanController::class, 'showDataLaporan'])->name('search.data_laporan');            
            route::put('/data/laporan/{LaporanKegiatan}/edit', [TimKegiatanController::class, 'editLaporanKegiatan'])->name('edit.laporan_kegiatan');

        });
    });
});

Route::group(['middleware' => 'auth'], function(){

    // Download 'Laporan Kegiatan' Function
    route::get('data/tahun_kegiatan/tim_kegiatan/laporan_kegiatan/{LaporanKegiatan}/download', [TimKegiatanController::class, 'downloadLaporan'])->name('download.laporan_kegiatan');
    
});