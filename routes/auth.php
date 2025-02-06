<?php

use App\Enums\AuthGuardEnum;
use App\Http\Controllers\Auth\Backend\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Customer\AuthenticatedSessionController as CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:' . AuthGuardEnum::ADMIN->value)->prefix(AuthGuardEnum::ADMIN->value)->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'index']);
    Route::get('login', [AuthenticatedSessionController::class, 'index'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'loginCheck'])->name('loginCheck');
    Route::get('/dynamic-css', [AuthenticatedSessionController::class, 'generateCss'])->name('dynamic-css');
});

Route::middleware('auth:' . AuthGuardEnum::ADMIN->value)->name('admin.')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
});

/** Customer login authentication */
Route::middleware('guest:' . AuthGuardEnum::CUSTOMER->value)->prefix(AuthGuardEnum::CUSTOMER->value)->group(function () {
    Route::get('/', [CustomerAuthController::class, 'index']);
    Route::get('login', [CustomerAuthController::class, 'index'])->name('customer.login');
    Route::get('register', [CustomerAuthController::class, 'reg'])->name('customer.register');
    Route::post('register', [CustomerAuthController::class, 'regpost'])->name('customer.register.submit');
    Route::post('login', [CustomerAuthController::class, 'store'])->name('customer.login.submit');
});

Route::middleware('auth:' . AuthGuardEnum::CUSTOMER->value)->prefix(AuthGuardEnum::CUSTOMER->value)->group(function () {
    Route::post('logout', [CustomerAuthController::class, 'destroy'])->name('customer.logout');
    Route::get('/auth-verify', [CustomerAuthController::class, 'auth_verify'])->name("customer.auth-verify");
    Route::post('/auth-verify', [CustomerAuthController::class, 'auth_verify_confirm'])->name("customer.auth-verify.confirm");

});
