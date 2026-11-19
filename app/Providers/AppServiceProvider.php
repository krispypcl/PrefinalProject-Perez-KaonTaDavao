<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // While developing, throw an error if a relationship is lazy-loaded
        // (the N+1 problem). This forces me to use with() / load() in the controllers.
        Model::preventLazyLoading(! app()->isProduction());
    }
}
