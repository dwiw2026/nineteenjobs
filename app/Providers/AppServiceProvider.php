<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        // Role-based gates
        Gate::define('admin', fn (User $user) => $user->isAdmin());
        Gate::define('isEmployer', fn (User $user) => $user->isEmployer());
        Gate::define('isJobSeeker', fn (User $user) => $user->isJobSeeker());
    }
}
