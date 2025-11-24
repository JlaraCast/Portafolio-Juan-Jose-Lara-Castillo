<?php

namespace App\Providers;

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
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
            
            // Set the application URL from the request
            if (isset($_SERVER['HTTP_HOST'])) {
                $url = 'https://' . $_SERVER['HTTP_HOST'];
                config(['app.url' => $url]);
                \URL::forceRootUrl($url);
            }
        }
    }
}
