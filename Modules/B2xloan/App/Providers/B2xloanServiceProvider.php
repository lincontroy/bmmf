<?php

namespace Modules\B2xloan\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\B2xloan\App\Repositories\Eloquent\B2xCurrencyRepository;
use Modules\B2xloan\App\Repositories\Eloquent\B2xLoanRepayRepository;
use Modules\B2xloan\App\Repositories\Eloquent\B2xLoanRepository;
use Modules\B2xloan\App\Repositories\Eloquent\PackageRepository;
use Modules\B2xloan\App\Repositories\Interfaces\B2xCurrencyRepositoryInterface;
use Modules\B2xloan\App\Repositories\Interfaces\B2xLoanRepayRepositoryInterface;
use Modules\B2xloan\App\Repositories\Interfaces\B2xLoanRepositoryInterface;
use Modules\B2xloan\App\Repositories\Interfaces\PackageRepositoryInterface;

class B2xloanServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'B2xloan';

    protected string $moduleNameLower = 'b2xloan';

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
        $this->app->bind(PackageRepositoryInterface::class, PackageRepository::class);
        $this->app->bind(B2xLoanRepositoryInterface::class, B2xLoanRepository::class);
        $this->app->bind(B2xCurrencyRepositoryInterface::class, B2xCurrencyRepository::class);
        $this->app->bind(B2xLoanRepayRepositoryInterface::class, B2xLoanRepayRepository::class);
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
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);
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
