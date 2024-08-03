<?php
namespace Robinboost\DebugbarDoping;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Robinboost\DebugbarDoping\Console\Commands\Test1Health;
use Robinboost\DebugbarDoping\Console\Commands\TestHealth;
use Illuminate\Support\ServiceProvider;
use Robinboost\DebugbarDoping\Http\Middleware\CustomCheckForMaintenanceMode;

class DebugbarDopingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishes([
            __DIR__ . '/../config/debuggbar.php' => config_path('debuggbar.php'),
        ]);

        $router = $this->app['router'];

        $middleware = $this->app->make(CheckForMaintenanceMode::class);

        if(method_exists($middleware, 'except')) {
            $middleware->except(['/api/_debugbar/check', '/api/_debugbar/check/tag']);
        } else if (method_exists($middleware, 'preventRequestsDuringMaintenance')) {
            $middleware->preventRequestsDuringMaintenance(except: [
                "v1/test/uri",
            ]);
        } else {
            $kernel->prependMiddlewareToGroup('api', CustomCheckForMaintenanceMode::class);
        }



        $this->commands([
            TestHealth::class,
            Test1Health::class
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/debuggbar.php', 'debuggbar');
    }
}
