<?php
/**
 * Created By: Henry Ejemuta
 * Project: laravel-monnify
 * Class Name: LaravelMonnifyServiceProvider.php
 * Date Created: 7/13/20
 * Time Created: 6:40 PM
 */

namespace HenryEjemuta\LaravelMonnify;

use HenryEjemuta\LaravelMonnify\Console\InstallLaravelMonnify;
use Illuminate\Support\ServiceProvider;


class LaravelMonnifyServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Boot the service provider.
     */
    public function boot()
    {
        if (function_exists('config_path') && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('monnify.php'),
            ], 'config');

            $this->commands([
                InstallLaravelMonnify::class,
            ]);
        }
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'monnify');

        $this->app->singleton('monnify', function($app)
        {
            $baseUrl = config('monnify.base_url');
            $instanceName = 'monnify';


            return new Monnify(
                $baseUrl,
                $instanceName,
                config('monnify')
            );
        });

    }
}
