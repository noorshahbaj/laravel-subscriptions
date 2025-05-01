<?php

use App\Http\Controllers\Subscriptions\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Subscriptions\PlanController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Subscriptions', 'middleware' => 'auth'], function () {
    Route::get('/plans', [PlanController::class, 'index'])->name('subscriptions.plans');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
