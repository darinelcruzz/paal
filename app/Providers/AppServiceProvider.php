<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\SalesAndQuotationsComposer;
use Illuminate\Support\Facades\View;
use App\Quotation;
use App\Observers\QuotationObserver;

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

        View::composer('*', SalesAndQuotationsComposer::class);
        Quotation::observe(QuotationObserver::class);
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
