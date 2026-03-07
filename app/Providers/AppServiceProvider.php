<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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

        \Illuminate\Support\Facades\Gate::define('manage-users', function ($user) {
            return in_array($user->role, ['super_admin', 'admin']);
        });

        \Illuminate\Support\Facades\Gate::define('manage-categories', function ($user) {
            return in_array($user->role, ['super_admin', 'admin', 'moderator']);
        });

        \Illuminate\Support\Facades\Gate::define('manage-operations', function ($user) {
            return in_array($user->role, ['super_admin', 'admin', 'moderator', 'support']);
        });

        if ($this->app->environment('production') || $this->app->environment('staging')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');

            // If the online server exposes the project root, we need to prefix assets with /public
            // This allows asset('css/style.css') to work both locally and online.
            config(['app.asset_url' => url('/') . '/public']);
        }
    }
}
