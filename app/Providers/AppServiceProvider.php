<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register any application services.
    }

    public function boot(): void
    {
        // Use Tailwind-style Bootstrap Paginator if available
        if (class_exists(\Laravel\Breeze\Breeze::class)) {
            Paginator::useBootstrapFive();
        }

        // Custom Blade components
        Blade::anonymousComponentPath(resource_path('views/components'));

        // Custom validation rules
        if (method_exists(\Illuminate\Support\Facades\Validator::class, 'extend')) {
            \Illuminate\Support\Facades\Validator::extend('ilap_phone', function ($attribute, $value) {
                return preg_match('/^(\+?[\d\s\-\(\)]{7,}){2,}$/', $value);
            });
        }
    }
}
