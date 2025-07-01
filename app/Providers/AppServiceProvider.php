<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        View::share('categories', Category::where('status', 1)->get());
        Paginator::useBootstrapFour();
        // Paginator::useBootstrapFive();
    }
}
