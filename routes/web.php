<?php

use App\Http\Controllers\Admin\BidangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Operator\RequestRoomController;
use App\Http\Controllers\Operator\ViewRoomController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('rooms', RoomsController::class);
    Route::resource('bidang', BidangController::class);
    Route::resource('user', UserController::class);
});

Route::middleware(['auth', 'verified', 'operator'])->prefix('opt')->name('opt.')->group(function () {
    Route::get('/dashboard', function () {
        return view('operator.dashboard');
    })->name('dashboard');

    Route::get('/room-request', [RequestRoomController::class, 'index'])->name('room-request');
    Route::post('/room-check', [RequestRoomController::class, 'roomCheck'])->name('room-check');
    Route::post('/request-store', [RequestRoomController::class, 'store'])->name('request-store');
    Route::resource('room', ViewRoomController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
