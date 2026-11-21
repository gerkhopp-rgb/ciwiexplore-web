<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;


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
         Event::listen(Login::class, function (Login $event) {
        ActivityLog::create([
            'user_id' => $event->user->getAuthIdentifier(),
            'aksi'    => 'login',
        ]);
    });
    }
}
