<?php

namespace App\Providers;

use App\FacadesClass\Backup;
use App\FacadesClass\Localizer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadHelpers();

        $this->app->bind('localizer', function ($app) {
            return new Localizer();
        });

        $this->app->bind('backup', function ($app) {
            return new Backup();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // create localize blade directive
        Blade::directive('localize', function ($expression) {
            return "<?php echo localize($expression); ?>";
        });
        Paginator::useBootstrapFour();

        Response::macro('success', function ($data = null, $message = null, $code = 200, $extraData = []) {
            return Response::json(array_merge([
                'success' => true,
                'data'    => $data,
                'message' => $message,
            ], $extraData), $code);
        });

        Response::macro('error', function ($data = null, $message = null, $code = 400, $extraData = []) {
            return Response::json(array_merge([
                'success' => false,
                'data'    => $data,
                'message' => $message,
            ], $extraData), $code);
        });
    }

    protected function loadHelpers()
    {

        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename) {
            require_once $filename;
        }

    }

}
