<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
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
        if (config('app.env') === 'staging') { // Verifica se está em homologação
            // Mail::alwaysTo('tiraosi@yahoo.com.br');
            Mail::alwaysTo('kevynbarbosa1@gmail.com');
        }
    }
}
