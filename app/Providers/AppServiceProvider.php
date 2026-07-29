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


        view()->composer('layouts.app', function ($view) {

            $overdue = Temuan::query()
                ->where('status', 'Open')
                ->whereNotNull('due_date')
                ->whereDate('due_date', '<', now())
                ->count();


            $menahun = Temuan::query()
                ->where('status', 'Open')
                ->where('created_at', '<', now()->subYear())
                ->count();


            $risikoTinggi = Temuan::query()
                ->where('status', 'Open')
                ->where('tingkat_risiko', 'Tinggi')
                ->count();


            $view->with(
                'sidebarWarningCount',
                $overdue + $menahun + $risikoTinggi
            );

        });
    }
}