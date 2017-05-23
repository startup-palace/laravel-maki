<?php

namespace StartupPalace\Maki;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/maki.php' => config_path('maki.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/maki'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/' . config('maki.templatePath')),
        ], 'views');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/maki.php', 'maki');
    }
}
