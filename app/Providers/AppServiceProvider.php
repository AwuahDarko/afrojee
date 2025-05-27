<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::componentNamespace('App\\View\\Components', 'app'); // default
        Blade::anonymousComponentNamespace('resources/views/frontend', 'ui');
        Model::automaticallyEagerLoadRelationships();
    }
}
