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
     * Bootstrap any application services.     */
    public function boot(): void
    {
        // Share notifications with admin layout
        View::composer(['layouts.admin', 'layouts.app'], function ($view) {
            if (Auth::check()) {
                $currentUser = Auth::user();
                $userId = $currentUser->id;

                $notificationTypes = ['all'];

                if ($currentUser->utype === 'ADM') {
                    $notificationTypes[] = 'admin';
                } elseif ($currentUser->utype === 'EMP') {
                    $notificationTypes[] = 'employee';
                } elseif ($currentUser->utype === 'CTM') {
                    $notificationTypes[] = 'customer';
                }

                // Debug: Log user 
                \Illuminate\Support\Facades\Log::info('Current User ID: ' . $userId . ', Type: ' . $currentUser->utype);
                \Illuminate\Support\Facades\Log::info('Notification Types: ' . implode(', ', $notificationTypes));

                $notifications = Notification::whereIn('type', $notificationTypes)
                    ->whereNull('deleted_at')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

                // Debug: Log số lượng thông báo tìm được
                \Illuminate\Support\Facades\Log::info('Found notifications: ' . $notifications->count());
                foreach ($notifications as $index => $notification) {
                    \Illuminate\Support\Facades\Log::info("Notification #{$index}: {$notification->id} - {$notification->name} - {$notification->type}");
                }

                $view->with('notifications', $notifications);
            } else {
                // Fallback cho user chưa login
                $view->with('notifications', collect([]));
            }
        });
    }
}
