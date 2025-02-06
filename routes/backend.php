<?php

use App\Enums\AuthGuardEnum;
use App\Http\Controllers\Backend\BackupSettingController;
use App\Http\Controllers\Backend\BuildLanguageSettingController;
use App\Http\Controllers\Backend\CommissionSettingController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\CustomerVerifyDocController;
use App\Http\Controllers\Backend\ExternalApiSettingController;
use App\Http\Controllers\Backend\FeeSettingController;
use App\Http\Controllers\Backend\LanguageSettingController;
use App\Http\Controllers\Backend\LocalizationController;
use App\Http\Controllers\Backend\NotificationSetupController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\SettingsEmailController;
use App\Http\Controllers\Backend\SettingsSMSController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Currency\AcceptCurrencyController;
use App\Http\Controllers\Currency\FiatCurrencyController;
use App\Http\Controllers\Currency\PaymentGatewayController;
use App\Http\Controllers\Dashboard\Backend\DashboardController;
use App\Http\Controllers\Roles\PermissionController;
use App\Http\Controllers\Roles\UserManageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix(AuthGuardEnum::ADMIN->value)->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /** Dashboard Report */
    Route::get('/dashboard/customer/chart/data', [DashboardController::class, 'customerChartData']);
    Route::get('/dashboard/txn/chart', [DashboardController::class, 'txnChartData']);
    Route::get('/dashboard/txn/fee/chart', [DashboardController::class, 'txnFeeChartData']);
    Route::get('/dashboard/txn/history/chart', [DashboardController::class, 'txnHistory']);
    Route::get('/dashboard/currency/chart', [DashboardController::class, 'acceptCurrencyChart']);
    Route::get('/investment/chart', [DashboardController::class, 'investmentChartData']);

    Route::get('lang/{lang}', [LocalizationController::class, 'switchLang'])->name('lang.switch');

    Route::prefix('setting')->as('setting.')->group(function () {
        /**
         * App setting route
         */
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::patch('/', [SettingsController::class, 'update'])->name('update');
        Route::get('commission-setup', [CommissionSettingController::class, 'index']
        )->name('commission');
        Route::post('commission-store', [CommissionSettingController::class, 'store']
        )->name('commission_store');
        Route::get('external-api-setup', [ExternalApiSettingController::class, 'index']
        )->name('external_api_setup');

        Route::get('external-api-setup-update/{id}', [ExternalApiSettingController::class, 'edit']
        )->name('external_api_setup_update');
        Route::patch('external-api-setup-update/{id}', [ExternalApiSettingController::class, 'update']
        )->name('external_api_setup_update');

        /**
         * Fee route
         */
        Route::resource('/fee-setting', FeeSettingController::class)->except(['create', 'view']);

        /**
         * Notification setup route
         */
        Route::get('/notification-setup', [NotificationSetupController::class, 'index'])->name(
            'notification-setup.index'
        );
        Route::patch('/notification-setup/{group}', [NotificationSetupController::class, 'update'])->name(
            'notification-setup.update'
        );

        /**
         * Email setting route
         */
        Route::prefix('email')->as('email.')->group(function () {
            Route::get('/', [SettingsEmailController::class, 'index'])->name('index');
            Route::patch('/', [SettingsEmailController::class, 'update'])->name('update');
            Route::post('/send', [SettingsEmailController::class, 'send'])->name('send');
        });

        /**
         * SMS setting route
         */
        Route::prefix('sms')->as('sms.')->group(function () {
            Route::get('/', [SettingsSMSController::class, 'index'])->name('index');
            Route::patch('/', [SettingsSMSController::class, 'update'])->name('update');
            Route::post('/send', [SettingsSMSController::class, 'send'])->name('send');
        });

        /**
         * Language route
         */
        Route::resource('/language', LanguageSettingController::class)->except(['create', 'view']);

        /**
         * Language build route
         */
        Route::prefix('/{language}/build')->as('language.build.')->group(function () {
            Route::get('/', [BuildLanguageSettingController::class, 'index'])->name('index');
            Route::post('/store', [BuildLanguageSettingController::class, 'store'])->name('store');
            Route::get('/data-table-ajax', [BuildLanguageSettingController::class, 'dataTableAjax'])->name(
                'data-table-ajax'
            );

            Route::patch('update/{key}', [BuildLanguageSettingController::class, 'update'])->name('update');
            Route::delete('delete/{key}', [BuildLanguageSettingController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('backup')->as('backup.')->group(function () {
            Route::get('/', [BackupSettingController::class, 'index'])->name('index');
            Route::get('/data-table-ajax', [BackupSettingController::class, 'dataTableAjax'])->name('data-table-ajax');
            Route::post('/store', [BackupSettingController::class, 'store'])->name('store');
            Route::delete('/delete-all', [BackupSettingController::class, 'destroyAll'])->name('delete.all');
            Route::delete('/delete', [BackupSettingController::class, 'destroy'])->name('delete');

            Route::get('/download', [BackupSettingController::class, 'download'])->name('download');
        });
    });

    Route::get('account-setting/{id}', [UserController::class, 'accountSetting'])->name('account-setting');
    Route::patch('account-setting/{id}', [UserController::class, 'updateAccountSetting'])->name(
        'update-account-setting'
    );

    Route::resource('/user', UserController::class);

    Route::resource('/role', RoleController::class)->except(['create', 'view']);

    Route::get('/role/users', [UserManageController::class, 'index'])->name('manage_users');
    Route::get('/role/users/edit', [UserManageController::class, 'edit'])->name('edit_users');
    Route::delete('/role/users/delete', [UserManageController::class, 'destroy'])->name('delete_users');
    Route::get('/role/users/create', [UserManageController::class, 'create'])->name('create_users');
    Route::resource('manage_permission', PermissionController::class);
    Route::resource('payment/setting/gateway', PaymentGatewayController::class)->names('payment.gateway')->except(
        ['show']
    );
    Route::resource('currency/setting/accept', AcceptCurrencyController::class)->names('accept.currency');

    Route::resource('currency/setting/fiat', FiatCurrencyController::class)->names('currency.fiat')->except(
        ['create', 'show']
    );

    Route::resource('customers', CustomerController::class)->names('customers');
    Route::get('verified-customers', [CustomerVerifyDocController::class, 'verifiedCustomer'])->name(
        'verified-customers'
    );
    Route::get('verified-canceled', [CustomerVerifyDocController::class, 'verifiedCanceledCustomer'])->name(
        'verified-canceled-customers'
    );
    Route::resource('customers-verify-doc', CustomerVerifyDocController::class)->names('customer-verify-doc');
});
