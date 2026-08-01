<?php

namespace App\Providers;

use App\Models\User;
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
        // Share the portfolio owner with the app layout
        View::composer('layouts.app', function ($view) {
            if (! array_key_exists('user', $view->getData())) {
                $view->with('user', User::first());
            }
        });

        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');

            // Set the application URL from the request
            if (isset($_SERVER['HTTP_HOST'])) {
                $url = 'https://'.$_SERVER['HTTP_HOST'];
                config(['app.url' => $url]);
                \URL::forceRootUrl($url);
            }
        }
    }
}
