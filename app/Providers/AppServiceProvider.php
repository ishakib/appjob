<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
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
        $appUrl = env('APP_URL', '');
        URL::forceRootUrl($appUrl);
        Paginator::currentPathResolver(function () use ($appUrl) {
            return $appUrl.'/'.request()->path();
        });
    }
}
