<?php

namespace Phycon\Larmin;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Phycon\Larmin\Utilities\Menu\Menu;

class LarminServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'phycon');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'phycon');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if( $this->app->runningInConsole() )
        {
            $this->bootForConsole();
        }

        \Validator::resolver( function ( $translator, $data, $rules, $messages ) {
            return new Validator( $translator, $data, $rules, $messages );
        } );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__ . '/../config/larmin.php', 'larmin' );

        App::bind( 'menu', function () {
            return new Menu();
        } );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ 'larmin' ];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes( [
            __DIR__ . '/../config/larmin.php' => config_path( 'larmin.php' ),
        ], 'larmin.config' );

        // Publishing the views and layout
        $this->publishes( [
            __DIR__ . '/../resources/views' => base_path( 'resources/views' ),
        ] );

        // Publishing the js and scss files
        $this->publishes([
            __DIR__.'/../resources/js' => base_path('resources/js'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/sass' => base_path('resources/sass'),
        ]);
    }
}
