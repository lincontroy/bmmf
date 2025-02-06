<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\Reports\App\Http\Controllers\ReportsController;

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
    Route::get('reports/transactions-logs', [ReportsController::class, 'index'])->name('transactions-logs');
    Route::get('reports/investment-history', [ReportsController::class, 'investmentHistory'])->name('investment-history');
    Route::get('reports/fees-history', [ReportsController::class, 'feesHistory'])->name('fees-history');
    Route::get('reports/login-history', [ReportsController::class, 'loginHistory'])->name('login-history');
});
