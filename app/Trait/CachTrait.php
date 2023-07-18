<?php

namespace App\Trait;

use App\Models\Cache;

trait CachTrait
{
    /**
     * update or insert cache key
     *
     * @param  string  $end_point
     * @return bool
     */
    public function update_endpoint($end_point)
    {
        $check = Cache::where('end_point', $end_point)->first();
        $lastCall = time();
        $duratoin = 86400;

        if ($check != null) {
            $check->update([
                'last_call_at' => $lastCall,
                'duration' => $duratoin,
            ]);

            return true;
        } else {
            $result = Cache::create([
                'end_point' => $end_point,
                'last_call_at' => $lastCall,
                'duration' => $duratoin,
            ]);
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /**
     * check if end point is expired
     *
     * @param  string  $end_point
     * @return bool
     */
    public function is_expired($end_point)
    {
        $cache = Cache::where('end_point', $end_point)->first();
        if ($cache != null) {
            if (time() > ($cache->last_call_at + $cache->duration)) {
                return true;
            }

            return false;
        }

        return true;
    }
}
