<?php

use Illuminate\Support\Facades\Route;
use Modules\Package\App\Http\Controllers\Api\PackageController;

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
    Route::controller(PackageController::class)->prefix('v1')->group(function () {
        Route::get('home/package', 'homePackage');
        Route::get('package', 'packages');
    });
});
