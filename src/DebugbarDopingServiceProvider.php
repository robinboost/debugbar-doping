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
            __DIR__ . '/../config/debugbar-doping.php' => config_path('debugbar-doping.php'),
        ]);

        $router = $this->app['router'];

        $this->app->make(\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class)
            ->except(['/api/v1/reels/comments']);


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
        $this->mergeConfigFrom(__DIR__ . '/../config/debugbar-doping.php', 'campaigns');
    }
}
