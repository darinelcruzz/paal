<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            base_path() . '\vendor\almasaeed2010\adminlte\bower_components' => public_path('adminlte/bower_components'),
            base_path() . '\vendor\almasaeed2010\adminlte\dist' => public_path('adminlte/dist'),
            base_path() . '\vendor\almasaeed2010\adminlte\plugins' => public_path('adminlte/plugins'),
        ], 'adminlte');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
