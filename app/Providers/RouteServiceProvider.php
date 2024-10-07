<?php

namespace App\Providers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Configure rate limiting
        $this->configureRateLimiting();

        // Define routes for the application
        $this->routes(function () {
            Route::prefix('api') // API routes properly registered
                ->middleware('api') // Attach 'api' middleware
                ->group(base_path('routes/api.php')); // Define API routes in routes/api.php

            Route::middleware('web') // Attach 'web' middleware
                ->group(base_path('routes/web.php')); // Define web routes in routes/web.php
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(100)->by($request->user()->id) // Limit for authenticated users
                : Limit::perMinute(10)->by($request->ip()); // Limit for guests based on IP
        });
    }
}
