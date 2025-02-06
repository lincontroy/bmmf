<?php

use App\Enums\AuthGuardEnum;
use App\Http\Controllers\CallBack\DepositPaymentCallBackController;
use App\Http\Controllers\Customer\AjaxRequestController;
use App\Http\Controllers\Customer\EarningController;
use App\Http\Controllers\Customer\HelplineController;
use App\Http\Controllers\Customer\OtpVerificationController;
use App\Http\Controllers\Customer\WalletManageController;
use App\Http\Controllers\Dashboard\Customer\Account\AccountController;
use App\Http\Controllers\Dashboard\Customer\Account\KycVerificationController;
use App\Http\Controllers\Dashboard\Customer\Account\PasswordChangeController;
use App\Http\Controllers\Dashboard\Customer\Account\ProfileController;
use App\Http\Controllers\Dashboard\Customer\Account\TwoFactorVerificationController;
use App\Http\Controllers\Dashboard\Customer\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'])->prefix(AuthGuardEnum::CUSTOMER->value)
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
        /** Handle Ajax Request */
        Route::post('/ajax/request/currency', [AjaxRequestController::class, 'loadCurrency']);
        Route::post('/ajax/request/fee', [AjaxRequestController::class, 'loadFees']);
        Route::post('/ajax/request/user', [AjaxRequestController::class, 'loadUser']);
        Route::post('/ajax/request/withdrawal/account', [AjaxRequestController::class, 'withdrawalAccount']);

        Route::get('otp/verify', [OtpVerificationController::class, 'codeVerify'])->name('otp.verify');
        Route::post('otp/verify/process', [OtpVerificationController::class, 'verify'])->name('otp.verify.process');
    });

// Route::get('account', [ActivationController::class, 'account.activate']);

Route::group(
    [
        'middleware' => ['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'],
        'prefix'     => AuthGuardEnum::CUSTOMER->value,
        'as'         => 'customer.',
    ],
    function () {
        // Route::resource('account', CustomerController::class)->names('account');
        Route::get('/dashboard/txn/chart', [DashboardController::class, 'txnChartData']);
        Route::get('/dashboard/payout/chart', [DashboardController::class, 'payoutChartData']);
        Route::get('/dashboard/investment/chart', [DashboardController::class, 'investmentChartData']);
        Route::get('/dashboard/teamTurnOver/chart', [DashboardController::class, 'teamTurnoverChartData']);
        Route::get('/dashboard/sponsorTurnover/chart', [DashboardController::class, 'sponsorTurnoverChartData']);
    }
);

Route::group(
    [
        'middleware' => ['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'],
        'prefix'     => AuthGuardEnum::CUSTOMER->value,
        'as'         => 'customer.',
    ],
    function () {
        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('/update-site-align', [ProfileController::class, 'update_site_align'])->name('update-site-align');

            Route::prefix('account')->as('account.')->group(function () {
                Route::get('/', [AccountController::class, 'index'])->name('index');
                Route::patch('/', [AccountController::class, 'update'])->name('update');
                Route::patch('/avatar', [AccountController::class, 'update_avatar'])->name('update_avatar');
            });

            Route::prefix('password-change')->as('password-change.')->group(function () {
                Route::get('/', [PasswordChangeController::class, 'index'])->name('index');
                Route::patch('/', [PasswordChangeController::class, 'update'])->name('update');
            });

            Route::prefix('two-factor')->as('two-factor.')->group(function () {
                Route::get('/', [TwoFactorVerificationController::class, 'index'])->name('index');
                Route::patch('/', [TwoFactorVerificationController::class, 'update'])->name('update');
            });

            Route::prefix('kyc-verification')->as('kyc-verification.')->group(function () {
                Route::get('/', [KycVerificationController::class, 'index'])->name('index');
                Route::post('/', [KycVerificationController::class, 'store'])->name('store');
            });
        });

        Route::get('/earning', [EarningController::class, 'index'])->name('invest_interest');
        Route::get('/earning-future', [EarningController::class, 'interestFuture'])->name('invest_interest_future');
        Route::get('/capital-return', [EarningController::class, 'CapitalReturn'])->name('capital_return');
        Route::get('/referral-commission', [EarningController::class, 'referralCommission'])->name('referral_commission');
        Route::get('/team-bonus', [EarningController::class, 'teamBonus'])->name('team_bonus');
        Route::get('/my-generation', [EarningController::class, 'myGeneration'])->name('my_generation');
        Route::get('helpline', [HelplineController::class, 'add'])->name('helpLine');
        Route::post('/helpline/send', [HelplineController::class, 'send']);

        Route::get('/wallet-manage', [WalletManageController::class, 'index'])->name('wallet_manage');
    }

);

Route::middleware(['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'])->group(function () {
    Route::get('deposit/stripe/success', [DepositPaymentCallBackController::class, 'stripeConfirm'])->name('stripe.success');
    Route::get('deposit/stripe/cancel', [DepositPaymentCallBackController::class, 'stripeCancel'])->name('stripe.cancel');
});

Route::post('deposit/coinpayment/ipn', [DepositPaymentCallBackController::class, 'coinPaymentConfirm'])->name('coinpayment.ipn');

