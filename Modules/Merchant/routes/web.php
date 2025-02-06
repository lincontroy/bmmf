<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\Merchant\App\Http\Controllers\MerchantAccountController;
use Modules\Merchant\App\Http\Controllers\MerchantFeeController;
use Modules\Merchant\App\Http\Controllers\MerchantPaymentInfoController;
use Modules\Merchant\App\Http\Controllers\WithdrawController;

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

require __DIR__ . '/customer.php';

Route::middleware(['auth', 'verified'])->prefix(AuthGuardEnum::ADMIN->value)->name('admin.')->group(function () {
    Route::resource('merchant', MerchantAccountController::class)->names('merchant.account');
    Route::get('confirmed/merchants', [MerchantAccountController::class, 'confirmMerchant'])->name('confirmMerchant');

    Route::resource('merchant-transactions', MerchantPaymentInfoController::class)->names('merchant.transactions');
    Route::get('merchant-transactions-count/{status}', [MerchantPaymentInfoController::class, 'totalCount'])->name('merchant.transactions.count');

    Route::get('merchant-fee', [MerchantFeeController::class, 'index'])->name('merchant.fee');
    Route::post('merchant-fee', [MerchantFeeController::class, 'store'])->name('merchant.create');
    Route::resource('merchant-withdraw', WithdrawController::class)->names('merchant.withdraw');
    Route::get('merchant-withdraw-pending', [WithdrawController::class, 'pendingWithdraw'])->name('merchant.withdraw-pending');
    Route::get('merchant-withdraw-confirmed', [WithdrawController::class, 'confirmWithdraw'])->name('merchant.withdraw-confirmed');
});
