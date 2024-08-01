<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'preventBackHistory'], function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'storelogin']);
        Route::get('/', function() {
            return redirect(route('login'));
        });
    });
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/home', function() {
            if (Auth::user()->role === 'Admin') {
                return redirect(route('admin.dashboard'));
            }elseif (Auth::user()->role === 'Ketua') {
                return redirect(route('ketua.homepage'));
            }elseif (Auth::user()->role === 'Anggota') {
                return redirect(route('anggota.homepage'));
            }
        });
        Route::prefix('admin')->name('admin.')->middleware(['userAccess:Admin'])->group(function() {
            route::get('/dashboard', [RedirectController::class, 'dashboard'])->name('dashboard');
        });
        Route::prefix('ketua')->name('ketua.')->middleware(['userAccess:Ketua'])->group(function() {
            route::get('/homepage', [RedirectController::class, 'homepage'])->name('homepage');
        });
        Route::prefix('anggota')->name('anggota.')->middleware(['userAccess:Anggota'])->group(function() {
            route::get('/homepage', [RedirectController::class, 'homepage'])->name('homepage');
        });
    });
});
