<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CartItem;
use App\Models\UserNotification;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

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
        // Share notifications with admin layout
        View::composer('layouts.admin', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $notifications = UserNotification::where('user_id', $userId)
                    ->with('notification')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

                $view->with('notifications', $notifications);
            }
        });
    }
}
