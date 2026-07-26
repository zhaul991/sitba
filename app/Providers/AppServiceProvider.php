<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Temuan;
use App\Observers\TemuanObserver;

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
        Temuan::observe(TemuanObserver::class);
    }
}