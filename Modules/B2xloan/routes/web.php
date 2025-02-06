<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\B2xloan\App\Http\Controllers\B2xloanController;
use Modules\B2xloan\App\Http\Controllers\B2xloanPackageController;
use Modules\B2xloan\App\Http\Controllers\B2xLoanPendingWithdrawController;
use Modules\B2xloan\App\Http\Controllers\B2xLoanRepayController;
use Modules\B2xloan\App\Http\Controllers\Customer\B2xLoanController as B2xLoanControllerAlias;
use Modules\B2xloan\App\Http\Controllers\Customer\RepaymentCallBackController;
use Modules\B2xloan\App\Http\Controllers\Customer\RepaymentController;

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
    Route::resource('b2xloan-package', B2xloanPackageController::class)->names('b2xloan.package');
    Route::get('b2x-loans', [B2xloanController::class, 'index'])->name('b2x-loans');
    Route::get('b2x-loans-summary', [B2xloanController::class, 'loanSummary'])->name('b2x-loans-summary');
    Route::get('b2x-closed-loans', [B2xloanController::class, 'closedLoans'])->name('b2x-closed-loans');

    Route::put('b2x-loans/{b2x_loans}', [B2xloanController::class, 'update'])->name('b2x-loans.update');
    Route::POST('b2x-loans/get-user', [B2xloanController::class, 'getUser'])->name('b2x-loan.getUser');

    Route::get('/month/repayment', [B2xLoanRepayController::class, 'index'])->name('month.repayment');
    Route::get('/repayments', [B2xLoanRepayController::class, 'create'])->name('repayments');
    Route::GET('b2x-loans-pending-withdraw', [B2xLoanPendingWithdrawController::class, 'index'])->name(
        'b2x-loans.pending-withdraw'
    );
    Route::put(
        'b2x-loans-pending-withdraw/{b2x_loans_pending_withdraw}',
        [B2xLoanPendingWithdrawController::class, 'update']
    )->name
    (
        'b2x-loans-pending-withdraw.update'
    );
});


Route::group(
    [
        'middleware' => ['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'],
        'prefix'     => AuthGuardEnum::CUSTOMER->value,
        'as'         => 'customer.',
    ],
    function () {
        Route::post('loan-calculator', [B2xLoanControllerAlias::class, 'loanCalculator'])->name('loan_calculator');
        Route::get('b2x-loan-list', [B2xLoanControllerAlias::class, 'b2xLoanList'])->name('b2x_loan_list');
        Route::post('b2x-loan-withdraw', [B2xLoanControllerAlias::class, 'b2xLoanList'])->name('b2x_loan_withdraw');
        Route::post('customer-withdraw-account', [B2xLoanControllerAlias::class, 'userWithdrawAccount']);
        Route::post('b2x-loan-withdraw-request', [B2xLoanControllerAlias::class, 'userLoanWithdrawRequest'])->name(
            'b2x_loan_withdraw_request'
        );
        Route::resource('b2x-Loan', B2xLoanControllerAlias::class)->names('b2x_loan');

        Route::get('repayment-process', [RepaymentController::class, 'payment'])->name('repayment.process');
        Route::resource('repayment', RepaymentController::class)->names(
            'repayment'
        );
        Route::get(
            'repayment-stripe-success',
            [RepaymentCallBackController::class, 'stripeConfirm']
        )->name('repayment_stripe_success');

        Route::get('repayment-stripe-cancel', [RepaymentCallBackController::class, 'stripeCancel'])->name(
            'repayment_stripe_cancel'
        );
    }
);
Route::post('repayment-coinpayment-ipn', [RepaymentCallBackController::class, 'coinPaymentConfirm'])->name(
    'customer.repayment.coinpayment.ipn'
);

