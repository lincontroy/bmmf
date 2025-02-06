<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\Package\App\Http\Controllers\Customer\PackageController as PackageControllerAlias;
use Modules\Package\App\Http\Controllers\PackageController;
use Modules\Package\App\Http\Controllers\PlanTimeController;

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

/*Route::group([], function () {
Route::resource('package', PackageController::class)->names('package');
});*/

Route::middleware(['auth', 'verified'])->prefix(AuthGuardEnum::ADMIN->value)->name('admin.')->group(function () {
    Route::resource('package', PackageController::class);
});

Route::middleware(['auth', 'verified'])->prefix(AuthGuardEnum::ADMIN->value)->name('admin.')->group(function () {
    Route::resource('plan-time', PlanTimeController::class);
});

Route::group(
    [
        'middleware' => ['auth:' . AuthGuardEnum::CUSTOMER->value, 'verified'],
        'prefix'     => AuthGuardEnum::CUSTOMER->value,
        'as'         => 'customer.',
    ],
    function () {

        Route::get('packages-purchased/{id}', [PackageControllerAlias::class, 'confirmPackage'])->name('packages_purchased');
        Route::get('purchased', [PackageControllerAlias::class, 'myPackages'])->name('my-packages');
        Route::resource(
            'packages',
            PackageControllerAlias::class
        )->names('packages');

    }
);
