<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\Support\App\Http\Controllers\SupportController;

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
    Route::get('support-search', [SupportController::class, 'search'])->name('admin.support.search');
    Route::get('support-onLoad', [SupportController::class, 'onLoad'])->name('admin.support.onLoad');
    Route::resource('support', SupportController::class)->names('admin.support');
});
