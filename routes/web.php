<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Subscriptions\PlanController;
use App\Http\Controllers\Subscriptions\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Subscriptions', 'middleware' => 'auth'], function () {
    Route::get('/plans', [PlanController::class, 'index'])->name('subscriptions.plans');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
});

Route::group(['namespace' => 'Account', 'prefix' => 'account', 'middleware' => 'auth'], function () {
    Route::get('/', [AccountController::class, 'index'])->name('account');

    Route::group(['namespace' => 'Subscriptions', 'prefix' => 'subscriptions'], function () {
        Route::get('/', [\App\Http\Controllers\Account\Subscriptions\SubscriptionController::class, 'index'])->name('account.subscriptions');
        Route::get('/cancel', [\App\Http\Controllers\Account\Subscriptions\SubscriptionController::class, 'cancelIndex'])->name('account.subscriptions.cancel');
        Route::post('/cancel', [\App\Http\Controllers\Account\Subscriptions\SubscriptionController::class, 'cancel']);

        Route::get('/resume', [\App\Http\Controllers\Account\Subscriptions\SubscriptionController::class, 'resumeIndex'])->name('account.subscriptions.resume');
        Route::post('/resume', [\App\Http\Controllers\Account\Subscriptions\SubscriptionController::class, 'resume']);
    });
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
