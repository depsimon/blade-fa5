<?php

namespace Depsimon\BladeFa5;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class BladeFa5ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        app(Fa5Factory::class)->registerBladeTag();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('blade-fa5.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(Fa5Factory::class, function () {
            $config = Collection::make(config('blade-fa5', []))->merge([
                'spritesheets_path' => base_path(config('blade-fa5.spritesheets_path'))
            ])->all();

            return new Fa5Factory($config);
        });
    }
}
