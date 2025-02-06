<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\Merchant\App\Http\Controllers\Customer\Callback\PaymentDepositCallBackController;
use Modules\Merchant\App\Http\Controllers\Customer\MerchantAccountRequestController;
use Modules\Merchant\App\Http\Controllers\Customer\MerchantCustomerInfoController;
use Modules\Merchant\App\Http\Controllers\Customer\MerchantDashboardController;
use Modules\Merchant\App\Http\Controllers\Customer\MerchantPaymentUrlController;
use Modules\Merchant\App\Http\Controllers\Customer\PaymentController;
use Modules\Merchant\App\Http\Controllers\Customer\TransactionRequestController;
use Modules\Merchant\App\Http\Controllers\Customer\WithdrawController;

Route::group(['middleware' => ['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'], 'prefix' => AuthGuardEnum::CUSTOMER->value, 'as' => 'customer.'], function () {
    Route::prefix('merchant')->name('merchant.')->group(function () {

        Route::get('/', [MerchantDashboardController::class, 'index'])->name('dashboard.index');

        Route::prefix('account-request')->as('account-request.')->group(function () {
            Route::get('/', [MerchantAccountRequestController::class, 'index'])->name('index');
            Route::get('/create', [MerchantAccountRequestController::class, 'create'])->name('create');
            Route::post('/', [MerchantAccountRequestController::class, 'store'])->name('store');
            Route::delete('/{account_request}', [MerchantAccountRequestController::class, 'destroy'])->name('destroy');
        });

        Route::resource('customer', MerchantCustomerInfoController::class)->except(['view', 'show']);

        Route::resource('payment-url', MerchantPaymentUrlController::class)->except(['view', 'show']);
        Route::get('payment-url/{payment_url}/view-payment-link', [MerchantPaymentUrlController::class, 'viewPaymentLink'])->name('payment-url.view-payment-link');

        Route::get('/transaction', [TransactionRequestController::class, 'index'])->name('transaction.index');

    });
});

Route::get('/payments/{payment_url}', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payments/{payment_url}', [PaymentController::class, 'processCustomer'])->name('payment.process-customer');
Route::post('/payments/{payment_url}/pay-crypto-currency/{customer_info}', [PaymentController::class, 'payCryptoCurrency'])->name('payment.pay-crypto-currency');
Route::get('payments/{payment_url}/deposit-process', [PaymentController::class, 'paymentDepositProcess'])->name('customer.payment.deposit.process');
Route::get('payments/{payment_url}/deposit-confirm', [PaymentController::class, 'paymentDepositConfirm'])->name('customer.payment.deposit.confirm');
Route::get('/payments/{payment_url}/expired', [PaymentController::class, 'paymentUrlExpired'])->name('payment.expired');


Route::get('payments/stripe/success', [PaymentDepositCallBackController::class, 'stripeConfirm'])->name('customer.payment.stripe.success');
Route::post('payments/coinpayment/ipn', [PaymentDepositCallBackController::class, 'coinPaymentConfirm'])->name('customer.payment.coinpayment.ipn');
Route::get('payments/stripe/cancel', [PaymentDepositCallBackController::class, 'stripeCancel'])->name('customer.payment.stripe.cancel');

Route::group(['middleware' => ['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'], 'prefix' => AuthGuardEnum::CUSTOMER->value], function () {
    Route::get('merchant/withdraw/confirm', [WithdrawController::class, 'withdrawConfirm'])->name('customer.merchant.withdraw.callback');
    Route::resource('merchant/withdraw', WithdrawController::class)->names('customer.merchant.withdraw');
});
