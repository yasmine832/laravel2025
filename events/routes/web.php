<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FAQController;


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

Route::controller(FAQController::class)->group(function () {
    Route::get('/faq', 'index')->name('faq');
    Route::post('/faq/categories', 'storeCategory')->name('faq.categories.store');
    Route::put('/faq/categories/{category}', 'updateCategory')->name('faq.categories.update');
    Route::delete('/faq/categories/{category}', 'destroyCategory')->name('faq.categories.destroy');
    Route::post('/faq/categories/{category}/items', 'storeItem')->name('faq.items.store');
    Route::put('/faq/items/{item}', 'updateItem')->name('faq.items.update');
    Route::delete('/faq/items/{item}', 'destroyItem')->name('faq.items.destroy');
});

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/news/{news}/comments', [NewsController::class, 'storeComment'])->name('news.comments.store');
    Route::delete('/news/{news}/comments/{comment}', [NewsController::class, 'destroyComment'])->name('news.comments.destroy');
});

Route::resource('news', NewsController::class);