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
        // Force HTTPS in production or when APP_URL starts with https
        if (config('app.env') === 'production' || str_starts_with(config('app.url'), 'https://')) {
            \URL::forceScheme('https');
            
            // Trust proxies for proper HTTPS detection
            $this->app['request']->server->set('HTTPS', 'on');
        }
        
        // Handle proxy headers if behind a load balancer/proxy
        if ($this->app['request']->header('X-Forwarded-Proto') === 'https') {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
