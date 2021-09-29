<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\SalesAndQuotationsComposer;
use App\Http\ViewComposers\MailboxesComposer;
use Illuminate\Support\Facades\View;
use App\{Ingress, Quotation, Movement, Order, Purchase};
use App\Observers\{IngressObserver, QuotationObserver, MovementObserver, OrderObserver, PurchaseObserver};

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
        $this->registerObservers();
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
