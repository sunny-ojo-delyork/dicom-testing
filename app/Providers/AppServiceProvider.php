<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
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

            ResetPassword::createUrlUsing(function ($notifiable, $token) {
                return env("SPA_URL") . "/password/reset?email={$notifiable->getEmailForPasswordReset()}&token={$token}";
            });
        }
  
}
