<?php

namespace Modules\Stake\App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Stake\App\Jobs\SendStakeInterestJob;
use Modules\Stake\App\Repositories\Eloquent\CustomerStakeInterestRepository;
use Modules\Stake\App\Repositories\Eloquent\CustomerStakeRepository;
use Modules\Stake\App\Repositories\Eloquent\StakePlanRepository;
use Modules\Stake\App\Repositories\Eloquent\StakeRateRepository;
use Modules\Stake\App\Repositories\Interfaces\CustomerStakeInterestRepositoryInterface;
use Modules\Stake\App\Repositories\Interfaces\CustomerStakeRepositoryInterface;
use Modules\Stake\App\Repositories\Interfaces\StakePlanRepositoryInterface;
use Modules\Stake\App\Repositories\Interfaces\StakeRateRepositoryInterface;

class StakeServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Stake';

    protected string $moduleNameLower = 'stake';

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
        $this->app->bind(StakePlanRepositoryInterface::class, StakePlanRepository::class);
        $this->app->bind(StakeRateRepositoryInterface::class, StakeRateRepository::class);
        $this->app->bind(CustomerStakeRepositoryInterface::class, CustomerStakeRepository::class);
        $this->app->bind(CustomerStakeInterestRepositoryInterface::class, CustomerStakeInterestRepository::class);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
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

        $this->app->booted(function () {

            $schedule = $this->app->make(Schedule::class);

            $schedule->call(function () {
                dispatch(new SendStakeInterestJob);
            })->daily();

        });
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

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
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

}
