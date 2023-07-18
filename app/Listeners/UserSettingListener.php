<?php

namespace App\Listeners;

use App\Events\UserSettingEvent;
use App\Models\UserSetting;

class UserSettingListener
{
    public function onCreate($event)
    {
        UserSetting::create([
            'user_id' => $event->user_id,
        ]);

        return true;
    }

    public function subscribe($events)
    {
        $events->listen(
            UserSettingEvent::class,
            'App\Listeners\UserSettingListener@onCreate'
        );
    }
}
