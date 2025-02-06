<?php

use App\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\Route;
use Modules\CMS\App\Http\Controllers\CMSAboutUsBannerController;
use Modules\CMS\App\Http\Controllers\CMSB2XCalculatorHeaderController;
use Modules\CMS\App\Http\Controllers\CMSB2XController;
use Modules\CMS\App\Http\Controllers\CMSB2XLoanBannerController;
use Modules\CMS\App\Http\Controllers\CMSB2XLoanController;
use Modules\CMS\App\Http\Controllers\CMSB2XLoanDetailsContentController;
use Modules\CMS\App\Http\Controllers\CMSB2XLoanDetailsHeaderController;
use Modules\CMS\App\Http\Controllers\CMSBGImageController;
use Modules\CMS\App\Http\Controllers\CMSBlogContentController;
use Modules\CMS\App\Http\Controllers\CMSBlogController;
use Modules\CMS\App\Http\Controllers\CMSBlogDetailTopBannerController;
use Modules\CMS\App\Http\Controllers\CMSBlogTopBannerController;
use Modules\CMS\App\Http\Controllers\CMSContactAddressController;
use Modules\CMS\App\Http\Controllers\CMSContactController;
use Modules\CMS\App\Http\Controllers\CMSContactTopBannerController;
use Modules\CMS\App\Http\Controllers\CMSFaqController;
use Modules\CMS\App\Http\Controllers\CMSFaqHeaderController;
use Modules\CMS\App\Http\Controllers\CMSHomeAboutController;
use Modules\CMS\App\Http\Controllers\CMSHomeSliderController;
use Modules\CMS\App\Http\Controllers\CMSJoinUsTodayController;
use Modules\CMS\App\Http\Controllers\CMSMenuController;
use Modules\CMS\App\Http\Controllers\CMSMerchantController;
use Modules\CMS\App\Http\Controllers\CMSMerchantTitleController;
use Modules\CMS\App\Http\Controllers\CMSMerchantTopBannerController;
use Modules\CMS\App\Http\Controllers\CMSOurDifferenceContentController;
use Modules\CMS\App\Http\Controllers\CMSOurDifferenceController;
use Modules\CMS\App\Http\Controllers\CMSOurDifferenceHeaderController;
use Modules\CMS\App\Http\Controllers\CMSOurRateContentController;
use Modules\CMS\App\Http\Controllers\CMSOurRateController;
use Modules\CMS\App\Http\Controllers\CMSOurRateHeaderController;
use Modules\CMS\App\Http\Controllers\CMSOurServiceContentController;
use Modules\CMS\App\Http\Controllers\CMSOurServiceController;
use Modules\CMS\App\Http\Controllers\CMSOurServiceHeaderController;
use Modules\CMS\App\Http\Controllers\CMSPackageBannerController;
use Modules\CMS\App\Http\Controllers\CMSPackageHeaderController;
use Modules\CMS\App\Http\Controllers\CMSPaymentWeAcceptController;
use Modules\CMS\App\Http\Controllers\CMSPaymentWeAcceptHeaderController;
use Modules\CMS\App\Http\Controllers\CMSQuickExchangeController;
use Modules\CMS\App\Http\Controllers\CMSSatisfiedCustomerController;
use Modules\CMS\App\Http\Controllers\CMSSatisfiedCustomerHeaderController;
use Modules\CMS\App\Http\Controllers\CMSServiceTopBannerController;
use Modules\CMS\App\Http\Controllers\CMSSocialIconController;
use Modules\CMS\App\Http\Controllers\CMSStakeBannerController;
use Modules\CMS\App\Http\Controllers\CMSStakeController;
use Modules\CMS\App\Http\Controllers\CMSTeamMemberBannerController;
use Modules\CMS\App\Http\Controllers\CMSTeamMemberController;
use Modules\CMS\App\Http\Controllers\CMSTeamMemberHeaderController;
use Modules\CMS\App\Http\Controllers\CMSTopInvestorBannerController;
use Modules\CMS\App\Http\Controllers\CMSTopInvestorController;
use Modules\CMS\App\Http\Controllers\CMSTopInvestorHeaderController;
use Modules\CMS\App\Http\Controllers\CMSTopInvestorTopBannerController;
use Modules\CMS\App\Http\Controllers\CMSWhyChoseController;
use Modules\CMS\App\Http\Controllers\CMSWhyChoseHeaderController;

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
Route::group(['middleware' => ['auth', 'verified'], 'prefix' => AuthGuardEnum::ADMIN->value . '/cms', 'as' => 'admin.cms.'], function () {

    /**
     * Menu routes
     */
    Route::group(['prefix' => '/menu', 'as' => 'menu.'], function () {
        Route::get('/', [CMSMenuController::class, 'index'])->name('index');
        Route::get('/{article}', [CMSMenuController::class, 'edit'])->name('edit');
        Route::patch('/{article}/update', [CMSMenuController::class, 'update'])->name('update');
        Route::get('/{language}/{menuName}', [CMSMenuController::class, 'getArticleLang'])->name('getArticleLang');
    });

    /**
     * Home slider routes
     */
    Route::group(['prefix' => '/home-slider', 'as' => 'home-slider.'], function () {
        Route::get('/', [CMSHomeSliderController::class, 'index'])->name('index');
        Route::post('/', [CMSHomeSliderController::class, 'store'])->name('store');
        Route::get('/{article}', [CMSHomeSliderController::class, 'edit'])->name('edit');
        Route::patch('/{article}/update', [CMSHomeSliderController::class, 'update'])->name('update');
        Route::get('/{language}/{article}', [CMSHomeSliderController::class, 'getArticleLang'])->name('getArticleLang');
        Route::delete('/{article}', [CMSHomeSliderController::class, 'destroy'])->name('destroy');
    });

    /**
     * Home slider routes
     */
    Route::group(['prefix' => '/social-icon', 'as' => 'social-icon.'], function () {
        Route::get('/', [CMSSocialIconController::class, 'index'])->name('index');
        Route::post('/', [CMSSocialIconController::class, 'store'])->name('store');
        Route::get('/{article}', [CMSSocialIconController::class, 'edit'])->name('edit');
        Route::patch('/{article}/update', [CMSSocialIconController::class, 'update'])->name('update');
        Route::delete('/{article}', [CMSSocialIconController::class, 'destroy'])->name('destroy');
    });

    /**
     * Home about routes
     */
    Route::group(['prefix' => '/home-about', 'as' => 'home-about.'], function () {
        Route::get('/', [CMSHomeAboutController::class, 'index'])->name('index');

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::get('/{article}', [CMSHomeAboutController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSHomeAboutController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSHomeAboutController::class, 'getArticleLang'])->name('getArticleLang');
        });

        Route::group(['prefix' => '/banner', 'as' => 'banner.'], function () {
            Route::get('/{article}', [CMSAboutUsBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSAboutUsBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSAboutUsBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });
    });

    /**
     * Package routes
     */
    Route::group(['prefix' => '/package', 'as' => 'package.'], function () {

        Route::group(['prefix' => '/banner', 'as' => 'banner.'], function () {
            Route::get('/', [CMSPackageBannerController::class, 'index'])->name('index');
            Route::get('/{article}', [CMSPackageBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSPackageBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSPackageBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}', [CMSPackageHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSPackageHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSPackageHeaderController::class, 'getArticleLang'])->name('getArticleLang');
        });
    });

    /**
     * Join us today routes
     */
    Route::group(['prefix' => '/join-us-today', 'as' => 'join-us-today.'], function () {
        Route::get('/', [CMSJoinUsTodayController::class, 'index'])->name('index');
        Route::get('/{article}', [CMSJoinUsTodayController::class, 'edit'])->name('edit');
        Route::patch('/{article}/update', [CMSJoinUsTodayController::class, 'update'])->name('update');
        Route::get('/{language}/{article}', [CMSJoinUsTodayController::class, 'getArticleLang'])->name('getArticleLang');
    });

    /**
     * Merchant routes
     */
    Route::group(['prefix' => '/merchant', 'as' => 'merchant.'], function () {

        Route::get('/', [CMSMerchantController::class, 'index'])->name('index');

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSMerchantController::class, 'store'])->name('store');
            Route::get('/{article}', [CMSMerchantController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSMerchantController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSMerchantController::class, 'getArticleLang'])->name('getArticleLang');
            Route::delete('/{article}', [CMSMerchantController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => '/title', 'as' => 'title.'], function () {
            Route::get('/{article}/edit', [CMSMerchantTitleController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSMerchantTitleController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSMerchantTitleController::class, 'getArticleLang'])->name('getArticleLang');
        });

        Route::group(['prefix' => '/top-banner', 'as' => 'top-banner.'], function () {
            Route::get('/{article}/edit', [CMSMerchantTopBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSMerchantTopBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSMerchantTopBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });
    });

    /**
     * QuickExchange routes
     */
    Route::group(['prefix' => '/quickexchange', 'as' => 'quickexchange.'], function () {
        Route::get('/', [CMSQuickExchangeController::class, 'index'])->name('index');
        Route::get('/{article}', [CMSQuickExchangeController::class, 'edit'])->name('edit');
        Route::patch('/{article}/update', [CMSQuickExchangeController::class, 'update'])->name('update');
        Route::get('/{language}/{article}', [CMSQuickExchangeController::class, 'getArticleLang'])->name('getArticleLang');
    });

    Route::group(['prefix' => '/bg-image', 'as' => 'bg-image.'], function () {
        Route::get('/', [CMSBGImageController::class, 'index'])->name('index');
        Route::get('/{article_id}/{slug}', [CMSBGImageController::class, 'edit'])->name('edit');
        Route::patch('/{article_id}/{slug}/update', [CMSBGImageController::class, 'update'])->name('update');
    });

    /**
     * Why chose routes
     */
    Route::group(['prefix' => '/why-chose', 'as' => 'why-chose.'], function () {

        Route::get('/', [CMSWhyChoseController::class, 'index'])->name('index');

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSWhyChoseController::class, 'store'])->name('store');
            Route::get('/{article}', [CMSWhyChoseController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSWhyChoseController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSWhyChoseController::class, 'getArticleLang'])->name('getArticleLang');
            Route::delete('/{article}', [CMSWhyChoseController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSWhyChoseHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSWhyChoseHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSWhyChoseHeaderController::class, 'getArticleLang'])->name('getArticleLang');
        });
    });

    /**
     * Satisfied customer routes
     */
    Route::group(['prefix' => '/satisfied-customer', 'as' => 'satisfied-customer.'], function () {

        Route::get('/', [CMSSatisfiedCustomerController::class, 'index'])->name('index');

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSSatisfiedCustomerController::class, 'store'])->name('store');
            Route::get('/{article}', [CMSSatisfiedCustomerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSSatisfiedCustomerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSSatisfiedCustomerController::class, 'getArticleLang'])->name('getArticleLang');
            Route::delete('/{article}', [CMSSatisfiedCustomerController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSSatisfiedCustomerHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSSatisfiedCustomerHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSSatisfiedCustomerHeaderController::class, 'getArticleLang'])->name('getArticleLang');
        });

    });

    /**
     * Faq routes
     */
    Route::group(['prefix' => '/faq', 'as' => 'faq.'], function () {

        Route::get('/', [CMSFaqController::class, 'index'])->name('index');

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSFaqController::class, 'store'])->name('store');
            Route::get('/{article}', [CMSFaqController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSFaqController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSFaqController::class, 'getArticleLang'])->name('getArticleLang');
            Route::delete('/{article}', [CMSFaqController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSFaqHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSFaqHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSFaqHeaderController::class, 'getArticleLang'])->name('getArticleLang');
        });

    });

    /**
     * Blog routes
     */
    Route::group(['prefix' => '/blog', 'as' => 'blog.'], function () {

        Route::get('/', [CMSBlogController::class, 'index'])->name('index');

        Route::group(['prefix' => '/top_banner', 'as' => 'top_banner.'], function () {
            Route::get('/{article}/edit', [CMSBlogTopBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSBlogTopBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSBlogTopBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });

        Route::group(['prefix' => '/details_top_banner', 'as' => 'details_top_banner.'], function () {
            Route::get('/{article}/edit', [CMSBlogDetailTopBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSBlogDetailTopBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSBlogDetailTopBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSBlogContentController::class, 'store'])->name('store');
            Route::get('/{article}', [CMSBlogContentController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSBlogContentController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSBlogContentController::class, 'getArticleLang'])->name('getArticleLang');
            Route::delete('/{article}', [CMSBlogContentController::class, 'destroy'])->name('destroy');
        });
    });

    /**
     * Contact routes
     */
    Route::group(['prefix' => '/contact', 'as' => 'contact.'], function () {

        Route::get('/', [CMSContactController::class, 'index'])->name('index');

        Route::group(['prefix' => '/top_banner', 'as' => 'top_banner.'], function () {
            Route::get('/{article}/edit', [CMSContactTopBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSContactTopBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSContactTopBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });

        Route::group(['prefix' => '/address', 'as' => 'address.'], function () {
            Route::get('/', [CMSContactAddressController::class, 'index'])->name('index');
            Route::post('/', [CMSContactAddressController::class, 'store'])->name('store');
            Route::get('/{article}', [CMSContactAddressController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSContactAddressController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSContactAddressController::class, 'getArticleLang'])->name('getArticleLang');
            Route::delete('/{article}', [CMSContactAddressController::class, 'destroy'])->name('destroy');
        });

    });

    /**
     * Payment we accept routes
     */
    Route::group(['prefix' => '/payment-we-accept', 'as' => 'payment-we-accept.'], function () {

        Route::get('/', [CMSPaymentWeAcceptController::class, 'index'])->name('index');

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSPaymentWeAcceptHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSPaymentWeAcceptHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSPaymentWeAcceptHeaderController::class, 'getArticleLang'])->name('getArticleLang');
        });
    });

    /**
     * Stake routes
     */
    Route::group(['prefix' => '/stake', 'as' => 'stake.'], function () {

        Route::get('/', [CMSStakeController::class, 'index'])->name('index');

        Route::group(['prefix' => '/banner', 'as' => 'banner.'], function () {
            Route::get('/{article}/edit', [CMSStakeBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSStakeBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSStakeBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });
    });

    /**
     * B2X routes
     */
    Route::group(['prefix' => '/b2x', 'as' => 'b2x.'], function () {

        Route::get('/', [CMSB2XController::class, 'index'])->name('index');

        Route::group(['prefix' => '/loan', 'as' => 'loan.'], function () {
            Route::get('/{article}/edit', [CMSB2XLoanController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSB2XLoanController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSB2XLoanController::class, 'getArticleLang'])->name('getArticleLang');
        });
        Route::group(['prefix' => '/loan-banner', 'as' => 'loan-banner.'], function () {
            Route::get('/{article}/edit', [CMSB2XLoanBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSB2XLoanBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSB2XLoanBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });
        Route::group(['prefix' => '/calculator-header', 'as' => 'calculator-header.'], function () {
            Route::get('/{article}/edit', [CMSB2XCalculatorHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSB2XCalculatorHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSB2XCalculatorHeaderController::class, 'getArticleLang'])->name('getArticleLang');
        });
        Route::group(['prefix' => '/loan-details-header', 'as' => 'loan-details-header.'], function () {
            Route::get('/{article}/edit', [CMSB2XLoanDetailsHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSB2XLoanDetailsHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSB2XLoanDetailsHeaderController::class, 'getArticleLang'])->name('getArticleLang');
        });
        Route::group(['prefix' => '/loan-details-content', 'as' => 'loan-details-content.'], function () {
            Route::get('/{article}/edit', [CMSB2XLoanDetailsContentController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSB2XLoanDetailsContentController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSB2XLoanDetailsContentController::class, 'getArticleLang'])->name('getArticleLang');
        });
    });

    /**
     * Top Investor routes
     */
    Route::group(['prefix' => '/top-investor', 'as' => 'top-investor.'], function () {

        Route::get('/', [CMSTopInvestorController::class, 'index'])->name('index');

        Route::group(['prefix' => '/banner', 'as' => 'banner.'], function () {
            Route::get('/{article}/edit', [CMSTopInvestorBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSTopInvestorBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSTopInvestorBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });

        Route::group(['prefix' => '/top-banner', 'as' => 'top-banner.'], function () {
            Route::get('/{article}/edit', [CMSTopInvestorTopBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSTopInvestorTopBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSTopInvestorTopBannerController::class, 'getArticleLang'])->name('getArticleLang');
        });
        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSTopInvestorHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSTopInvestorHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSTopInvestorHeaderController::class, 'getArticleLang'])->name('getArticleLang');
        });
    });

    /**
     * Our Service routes
     */
    Route::group(['prefix' => '/our-service', 'as' => 'our-service.'], function () {

        Route::get('/', [CMSOurServiceController::class, 'index'])->name('index');

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSOurServiceContentController::class, 'store'])->name('store');
            Route::get('/{article}/edit', [CMSOurServiceContentController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSOurServiceContentController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSOurServiceContentController::class, 'getArticleDataLang'])->name('getArticleDataLang');
            Route::delete('/{article}', [CMSOurServiceContentController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSOurServiceHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSOurServiceHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSOurServiceHeaderController::class, 'getArticleDataLang'])->name('getArticleDataLang');
        });
        Route::group(['prefix' => '/top-banner', 'as' => 'top-banner.'], function () {
            Route::get('/{article}/edit', [CMSServiceTopBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSServiceTopBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSServiceTopBannerController::class, 'getArticleDataLang'])->name('getArticleDataLang');
        });
    });

    /**
     * Our rate routes
     */
    Route::group(['prefix' => '/our-rate', 'as' => 'our-rate.'], function () {

        Route::get('/', [CMSOurRateController::class, 'index'])->name('index');

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSOurRateContentController::class, 'store'])->name('store');
            Route::get('/{article}/edit', [CMSOurRateContentController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSOurRateContentController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSOurRateContentController::class, 'getArticleDataLang'])->name('getArticleDataLang');
            Route::delete('/{article}', [CMSOurRateContentController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSOurRateHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSOurRateHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSOurRateHeaderController::class, 'getArticleDataLang'])->name('getArticleDataLang');
        });
    });

    /**
     * Team Member routes
     */
    Route::group(['prefix' => '/team-member', 'as' => 'team-member.'], function () {

        Route::get('/', [CMSTeamMemberController::class, 'index'])->name('index');

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSTeamMemberController::class, 'store'])->name('store');
            Route::get('/{team_member}', [CMSTeamMemberController::class, 'edit'])->name('edit');
            Route::patch('/{team_member}/update', [CMSTeamMemberController::class, 'update'])->name('update');
            Route::get('/{language}/{team_member}', [CMSTeamMemberController::class, 'getArticleLang'])->name('getArticleLang');
            Route::delete('/{team_member}', [CMSTeamMemberController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => '/banner', 'as' => 'banner.'], function () {
            Route::get('/{article}/edit', [CMSTeamMemberBannerController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSTeamMemberBannerController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSTeamMemberBannerController::class, 'getArticleDataLang'])->name('getArticleDataLang');
        });

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSTeamMemberHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSTeamMemberHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSTeamMemberHeaderController::class, 'getArticleDataLang'])->name('getArticleDataLang');
        });
    });

    /**
     * Our Difference routes
     */
    Route::group(['prefix' => '/our-difference', 'as' => 'our-difference.'], function () {

        Route::get('/', [CMSOurDifferenceController::class, 'index'])->name('index');

        Route::group(['prefix' => '/header', 'as' => 'header.'], function () {
            Route::get('/{article}/edit', [CMSOurDifferenceHeaderController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSOurDifferenceHeaderController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSOurDifferenceHeaderController::class, 'getArticleDataLang'])->name('getArticleDataLang');
        });

        Route::group(['prefix' => '/content', 'as' => 'content.'], function () {
            Route::post('/', [CMSOurDifferenceContentController::class, 'store'])->name('store');
            Route::get('/{article}', [CMSOurDifferenceContentController::class, 'edit'])->name('edit');
            Route::patch('/{article}/update', [CMSOurDifferenceContentController::class, 'update'])->name('update');
            Route::get('/{language}/{article}', [CMSOurDifferenceContentController::class, 'getArticleDataLang'])->name('getArticleDataLang');
            Route::delete('/{article}', [CMSOurDifferenceContentController::class, 'destroy'])->name('destroy');
        });
    });
});
