<?php

namespace App\Providers;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
            Paginator::useBootstrapFive();
            Paginator::useBootstrapFour();
            View::composer('*', function ($view) {
            $cartItems = Cart::getContent();
            $view->with('cartItems', $cartItems);
        });
        }
}
