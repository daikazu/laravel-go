<?php

namespace Daikazu\LaravelGo;

use Illuminate\Support\ServiceProvider;

class LaravelGoServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'daikazu');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'daikazu');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
       $this->mergeConfigFrom(__DIR__.'/../config/laravelgo.php', 'laravelgo');

        // Register the service the package provides.
        $this->app->singleton('laravelgo', function ($app) {
            return new LaravelGo;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelgo'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
       $this->publishes([
           __DIR__.'/../config/laravelgo.php' => config_path('laravelgo.php'),
       ], 'laravelgo.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/daikazu'),
        ], 'laravelgo.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/daikazu'),
        ], 'laravelgo.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/daikazu'),
        ], 'laravelgo.views');*/

        // Registering package commands.
        $this->commands([
            Console\InstallCommand::class,
            Console\StaticPageCommand::class,
        ]);
    }
}
