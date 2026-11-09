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
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(resource_path('views/layouts'), 'layouts');

        \Illuminate\Support\Facades\Gate::policy(\App\Models\Page::class, \App\Policies\PagePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\MenuItem::class, \App\Policies\MenuItemPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Category::class, \App\Policies\CategoryPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);
    }
}
