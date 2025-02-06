<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\QuickExchange\App\Http\Controllers\QuickExchangeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => AuthGuardEnum::ADMIN->value], function () {
    Route::put('quickexchange/transaction/update', [QuickExchangeController::class, 'transactionUpdate'])->name('quickexchange.tx.update');
    Route::get('quickexchange/transaction', [QuickExchangeController::class, 'transaction'])->name('quickexchange.transaction');
    Route::get('quickexchange/request', [QuickExchangeController::class, 'request'])->name('quickexchange.request');
    Route::resource('quickexchange', QuickExchangeController::class)->names('quickexchange');
});
