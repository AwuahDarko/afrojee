<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SignInController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    // Route::get('/', function () {
    //     return 'Admin Dashboard';
    // });
    Route::get('/', [SignInController::class, 'index'])->name('admin.signin');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Add more admin routes as needed
    Route::get('/billing', function () {
        return view('backend.temp.billing');
    })->name('admin.billing');

    Route::get('/icons', function () {
        return view('backend.temp.icons');
    })->name('admin.icons');

    Route::get('/tables', function () {
        return view('backend.temp.tables');
    })->name('admin.tables');

    Route::get('/vr', function () {
        return view('backend.temp.virtual-reality');
    })->name('admin.vr');

    Route::get('/notification', function () {
        return view('backend.temp.notification');
    })->name('admin.notification');

    Route::get('/rtl', function () {
        return view('backend.temp.rtl');
    })->name('admin.rtl');

     Route::get('/profile', function () {
        return view('backend.temp.profile');
    })->name('admin.profile');
});