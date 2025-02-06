<?php

namespace Modules\Merchant\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Merchant\App\Repositories\Eloquent\MerchantAcceptCoinRepository;
use Modules\Merchant\App\Repositories\Eloquent\MerchantAcceptedCoinRepository;
use Modules\Merchant\App\Repositories\Eloquent\MerchantAccountRepository;
use Modules\Merchant\App\Repositories\Eloquent\MerchantBalanceRepository;
use Modules\Merchant\App\Repositories\Eloquent\MerchantCustomerInfoRepository;
use Modules\Merchant\App\Repositories\Eloquent\MerchantFeeRepository;
use Modules\Merchant\App\Repositories\Eloquent\MerchantPaymentInfoRepository;
use Modules\Merchant\App\Repositories\Eloquent\MerchantPaymentTransactionRepository;
use Modules\Merchant\App\Repositories\Eloquent\MerchantPaymentUrlRepository;
use Modules\Merchant\App\Repositories\Eloquent\WithdrawRepository;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAcceptCoinRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAcceptedCoinRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAccountRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantBalanceRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantCustomerInfoRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantFeeRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentInfoRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentTransactionRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentUrlRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\WithdrawRepositoryInterface;

class MerchantServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Merchant';

    protected string $moduleNameLower = 'merchant';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/migrations'));
        $this->app->bind(MerchantAccountRepositoryInterface::class, MerchantAccountRepository::class);
        $this->app->bind(MerchantPaymentInfoRepositoryInterface::class, MerchantPaymentInfoRepository::class);
        $this->app->bind(MerchantFeeRepositoryInterface::class, MerchantFeeRepository::class);
        $this->app->bind(WithdrawRepositoryInterface::class, WithdrawRepository::class);
        $this->app->bind(MerchantCustomerInfoRepositoryInterface::class, MerchantCustomerInfoRepository::class);
        $this->app->bind(MerchantPaymentUrlRepositoryInterface::class, MerchantPaymentUrlRepository::class);
        $this->app->bind(MerchantAcceptCoinRepositoryInterface::class, MerchantAcceptCoinRepository::class);
        $this->app->bind(MerchantPaymentTransactionRepositoryInterface::class, MerchantPaymentTransactionRepository::class);
        $this->app->bind(MerchantBalanceRepositoryInterface::class, MerchantBalanceRepository::class);
        $this->app->bind(MerchantAcceptedCoinRepositoryInterface::class, MerchantAcceptedCoinRepository::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {

// $this->app->booted(function () {

//     $schedule = $this->app->make(Schedule::class);

//     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
        }

    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php')], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath   = resource_path('views/modules/' . $this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace') . '\\' . $this->moduleName . '\\' . config('modules.paths.generator.component-class.path'));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];

        foreach (config('view.paths') as $path) {

            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }

        }

        return $paths;
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

}
