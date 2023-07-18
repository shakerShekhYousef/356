<?php

namespace App\Listeners;

use App\Events\TokenFcmEvent;
use App\Models\FcmToken;

class TokenFcmListener
{
    public function onCreate($event)
    {
        $fcmToken = FcmToken::where([
            ['user_id', $event->user_id],
            ['device_id', $event->device_id],
        ])->first();
        if ($fcmToken) {
            $fcmToken->update(['token' => $event->token]);
        } else {
            FcmToken::create([
                'user_id' => $event->user_id,
                'device_id' => $event->device_id,
                'token' => $event->token,
            ]);
        }

        return true;
    }

    public function subscribe($events)
    {
        $events->listen(
            TokenFcmEvent::class,
            'App\Listeners\TokenFcmListener@onCreate'
        );
    }
}
