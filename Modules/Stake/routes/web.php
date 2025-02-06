<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\Stake\App\Http\Controllers\Customer\StakeController as CustomerStakeController;
use Modules\Stake\App\Http\Controllers\Customer\SubscriptionController as CustomerSubscriptionController;
use Modules\Stake\App\Http\Controllers\StakeController;
use Modules\Stake\App\Http\Controllers\SubscriptionController;

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
    Route::resource('stake', StakeController::class)->names('stake');
    Route::resource('subscription', SubscriptionController::class)->names('subscription');
});

Route::group(['middleware' => ['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'], 'prefix' => AuthGuardEnum::CUSTOMER->value], function () {
    Route::resource('stake/plan', CustomerStakeController::class)->names('customer.stake.plan');
    Route::resource('subscription', CustomerSubscriptionController::class)->names('customer.subscription');

});
