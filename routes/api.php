<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\OurServiceController;
use App\Http\Controllers\Api\SettingApiController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TeamMemberController;
use App\Http\Controllers\Api\TopInvestorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware(['language'])->group(function () {

    Route::controller(HomeController::class)->prefix('v1')->group(function () {
        Route::get('home/menus', 'menus');
        Route::get('home/footer_menus', 'footerMenus');
        Route::get('home/slider', 'homeSlider');
        Route::get('home/merchant', 'homeMerchant');
        Route::get('merchant', 'merchant');
        Route::get('merchant/details', 'merchantDetails');
        Route::get('home/choose', 'homeWhyChoose');
        Route::post('home/registration', 'registration');
        Route::get('home/satisfy_customer', 'satisfyCustomer');
        Route::get('home/faq', 'faq');
        Route::get('home/payment_accept', 'gatewayList');
        Route::get('home/social_icon', 'socialIcon');
        Route::get('bg_image', 'bgImage');
    });

    Route::controller(AboutController::class)->prefix('v1')->group(function () {
        Route::get('home/about', 'homeAbout');
        Route::get('about', 'about');
    });

    Route::controller(BlogController::class)->prefix('v1')->group(function () {
        Route::get('blog', 'blog');
        Route::get('blog_details', 'blogDetails');
    });

    Route::controller(SettingsController::class)->prefix('v1')->group(function () {
        Route::get('setting', 'settingInfo');
    });

    Route::controller(TeamMemberController::class)->prefix('v1')->group(function () {
        Route::get('team_member', 'teamMember');
    });

    Route::controller(ContactUsController::class)->prefix('v1')->group(function () {
        Route::post('contact_us', 'contactUs');
        Route::get('contact_us', 'contactUsBanner');
    });

    Route::controller(TopInvestorController::class)->prefix('v1')->group(function () {
        Route::get('home/top_investors', 'homeTopInvestors');
        Route::get('top_investors', 'topInvestors');
    });

    Route::controller(LanguageController::class)->prefix('v1')->group(function () {
        Route::get('language', 'languages');
    });

    Route::controller(OurServiceController::class)->prefix('v1')->group(function () {
        Route::get('our_services', 'ourServices');
    });
});

Route::prefix('v1')->as('api.v1.')->group(function () {
    Route::get('system-info', [SettingApiController::class, 'systemInfo'])->name('systemInfo');
});