<?php

namespace App\Providers;

use App\Enums\AuthGuardEnum;
use App\Enums\NotificationEnum;
use App\Services\MessageService;
use App\Services\NotificationService;
use App\Services\SettingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $settingService = app(SettingService::class);
            $setting        = $settingService->findById();
            $messageService = app(MessageService::class);

            $view->with('_setting', $setting);

            if (auth(AuthGuardEnum::ADMIN->value)->check()) {
                $view->with('_auth_user', auth(AuthGuardEnum::ADMIN->value)->user());
                $countUnreadMessage = $messageService->countUnreadMessage();

                $view->with('_countMessage', $countUnreadMessage);
            }

            if (auth(AuthGuardEnum::CUSTOMER->value)->check()) {

                $notificationService = app(NotificationService::class);

                $unreadNotify      = $notificationService->all(['status' => NotificationEnum::UNREAD->value, 'customer_id' => auth(AuthGuardEnum::CUSTOMER->value)->id()])->take(10) ?? [];
                $unreadNotifyCount = $notificationService->countByAttributes(['status' => NotificationEnum::UNREAD->value, 'customer_id' => auth(AuthGuardEnum::CUSTOMER->value)->id()]) ?? 0;

                $view->with('_notifications', $unreadNotify);
                $view->with('_notificationCount', $unreadNotifyCount);
                $view->with('_auth_user', auth(AuthGuardEnum::CUSTOMER->value)->user());
                $userId = auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id;

                $countUnreadMessage = $messageService->countUnreadMessage($userId);
                $view->with('_countMessage', $countUnreadMessage);
            }

        });
    }

}
