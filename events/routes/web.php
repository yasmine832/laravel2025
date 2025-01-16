<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('toggle-admin');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('create-user');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('store-user');
    });
});

Route::resource('news', NewsController::class);