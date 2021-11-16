<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\SalesAndQuotationsComposer;
use App\Http\ViewComposers\MailboxesComposer;
use Illuminate\Support\Facades\View;
use App\{Ingress, Quotation, Movement, Order, Purchase};
use App\Observers\{IngressObserver, QuotationObserver, MovementObserver, OrderObserver, PurchaseObserver};
use ConsoleTVs\Charts\Registrar as Charts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $this->publishes([
            base_path() . '\vendor\almasaeed2010\adminlte\bower_components' => public_path('adminlte/bower_components'),
            base_path() . '\vendor\almasaeed2010\adminlte\dist' => public_path('adminlte/dist'),
            base_path() . '\vendor\almasaeed2010\adminlte\plugins' => public_path('adminlte/plugins'),
        ], 'adminlte');

        View::composer('*', SalesAndQuotationsComposer::class);
        $this->registerObservers();
        $charts->register([
            \App\Charts\BasicChart::class,
            \App\Charts\CategoriesChart::class,
            \App\Charts\ShippingsChart::class,
            \App\Charts\PlacesChart::class,
        ]);
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

    public function registerObservers()
    {
        Ingress::observe(IngressObserver::class);
        Quotation::observe(QuotationObserver::class);
        Movement::observe(MovementObserver::class);
        Order::observe(OrderObserver::class);
        Purchase::observe(PurchaseObserver::class);
    }
}
