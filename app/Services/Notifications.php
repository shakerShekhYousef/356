<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Live;
use App\Trait\ApiTrait;
use App\Trait\NotificationTrait;
use Exception;

class Notifications
{
    use ApiTrait, NotificationTrait;

    public function live()
    {
        $fixtures = Live::with(['fixture'])->get();
        foreach ($fixtures as $fix) {
            try {
                if ($fix->fixture != null) {
                    $fixture = $fix->fixture;
                    $details = $this->fixture_details($fix->fixture_id);
                    $fav = Favorite::with(['user'])->where('league_id', $fixture->league_id)
                        ->orWhere('team_id', $fixture->hom_team_id)
                        ->orWhere('team_id', $fixture->away_team_id)->get();
                    foreach ($fav as $f) {
                        foreach ($details['response'] as $event) {
                            $user = $f->user;
                            $title = $event['type'];
                            $message = $event['player']['name'].' '.$event['team']['name'];
                            $this->send_event_notification($user, $title, $message);
                        }
                    }
                }
            } catch (Exception $e) {
            }
        }
    }
}
