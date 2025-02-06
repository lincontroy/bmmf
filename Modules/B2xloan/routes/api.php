<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\B2xloan\App\Http\Controllers\Api\B2xLoanController;

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
    Route::controller(B2xLoanController::class)->prefix('v1')->group(function () {
        Route::get('b2x_loan', 'b2xLoan');
        Route::get('difference', 'difference');
        Route::get('our_rates', 'ourRate');
        Route::get('join_today', 'joinToday');
        Route::get('b2x_packages', 'b2xPackage');
        Route::Post('b2x_calculator', 'b2xLoanCalculator');
    });
});
