<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\Finance\App\Http\Controllers\Customer\DepositController as CustomerDepositController;
use Modules\Finance\App\Http\Controllers\Customer\TransferController as CustomerTransferController;
use Modules\Finance\App\Http\Controllers\Customer\WithdrawController as CustomerWithdrawController;
use Modules\Finance\App\Http\Controllers\DepositController;
use Modules\Finance\App\Http\Controllers\PendingDepositController;
use Modules\Finance\App\Http\Controllers\PendingWithdrawController;
use Modules\Finance\App\Http\Controllers\TransferController;
use Modules\Finance\App\Http\Controllers\WithdrawController;

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

Route::group(['middleware' => ['auth:' . AuthGuardEnum::ADMIN->value, 'verified'], 'prefix' => AuthGuardEnum::ADMIN->value], function () {
    Route::resource('finance/deposit', DepositController::class);
    Route::resource('finance/pending-deposit', PendingDepositController::class);
    Route::get('finance/credit', [DepositController::class, 'addCredit'])->name('credit');
    Route::POST('finance/get-user', [DepositController::class, 'getUser'])->name('admin.finance.getUser');
    Route::POST('finance/credit/generatePdf', [DepositController::class, 'generatePdf'])->name(
        'admin.finance.generatePdf'
    );
    Route::resource('finance/withdraw', WithdrawController::class);

    Route::post('finance/pending-withdraw/user-info', [PendingWithdrawController::class, 'userInfo'])->name('withdraw_user_info');

    Route::resource('finance/pending-withdraw', PendingWithdrawController::class);
    Route::resource('finance/transfer', TransferController::class);
});

Route::group(['middleware' => ['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'], 'prefix' => AuthGuardEnum::CUSTOMER->value], function () {
    Route::get('finance/deposit/process', [CustomerDepositController::class, 'payment'])->name('customer.deposit.process');
    Route::resource('finance/deposit', CustomerDepositController::class)->names('customer.deposit');
    Route::get('finance/transfer/confirm', [CustomerTransferController::class, 'transferConfirm'])->name('customer.transfer.callback');
    Route::get('finance/withdraw/confirm', [CustomerWithdrawController::class, 'withdrawConfirm'])->name('customer.withdraw.callback');
    Route::get('finance/withdraw/account', [CustomerWithdrawController::class, 'accountList'])->name('customer.withdraw.account.list');
    Route::get('finance/withdraw/account/create', [CustomerWithdrawController::class, 'withdrawalAccount'])->name('customer.withdraw.account.create');
    Route::post('finance/withdraw/account/store', [CustomerWithdrawController::class, 'withdrawalAccountStore'])->name('customer.withdraw.account.store');
    Route::delete('finance/withdraw/account/destroy', [CustomerWithdrawController::class, 'withdrawalAccountDestroy'])->name('customer.withdraw.account.destroy');

    Route::resource('finance/transfer', CustomerTransferController::class)->names('customer.transfer');
    Route::resource('finance/withdraw', CustomerWithdrawController::class)->names('customer.withdraw');
});
