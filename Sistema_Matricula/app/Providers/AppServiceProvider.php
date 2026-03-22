<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
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
        //para que acepte salir por https


    {
       if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        URL::forceScheme('https');
    }

    // El admin ve lo marcado con 'admin-only'
    Gate::define('admin-only', function ($user) {
        return $user->rol === 'admin';
    });

    // El docente ve lo marcado con 'docente-only'
    Gate::define('docente-only', function ($user) {
        return $user->rol === 'docentes'; 
    });

    }
}
