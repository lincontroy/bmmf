<?php

use Illuminate\Support\Facades\Route;
use Modules\QuickExchange\App\Http\Controllers\Api\QuickExchangeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware(['language'])->group(function () {
    Route::controller(QuickExchangeController::class)->prefix('v1')->group(function () {
        Route::get('quick_exchange', 'quickExchange');
        Route::get('quick_exchange/support_coins', 'quickExchangeSupportCoins');
        Route::post('quick_exchange/rate', 'quickExchangeRate');
        Route::get('quick_exchange/transaction', 'quickExchangeTransaction');
        Route::post('quick_exchange/nextRequest', 'quickExchangeNext');
        Route::post('quick_exchange/confirm', 'quickExchangeStore');
    });
});
