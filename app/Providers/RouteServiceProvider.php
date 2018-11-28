<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        //

        parent::boot();
    }

    public function map()
    {

        $this->mapCoffeeRoutes();
        $this->mapMailboxesRoutes();
        $this->mapPaalRoutes();
        $this->mapPublicRoutes();

        $this->mapApiRoutes();
    }

    protected function mapPublicRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/public.php'));
    }

    protected function mapCoffeeRoutes()
    {
        Route::middleware(['web', 'auth', 'coffee'])
             ->namespace($this->namespace)
             ->group(base_path('routes/coffee.php'));
    }

    protected function mapMailboxesRoutes()
    {
        Route::middleware(['web', 'auth', 'mailboxes'])
             ->namespace($this->namespace)
             ->group(base_path('routes/mailboxes.php'));
    }

    protected function mapPaalRoutes()
    {
        Route::middleware(['web', 'auth', 'paal'])
             ->namespace($this->namespace)
             ->group(base_path('routes/paal.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware(['web', 'auth'])
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
