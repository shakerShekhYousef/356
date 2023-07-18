<?php

use App\Models\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if (! function_exists('is_expired')) {
    function is_expired($end_point)
    {
        $check = Cache::where('end_point', $end_point)->first();
        if ($check != null) {
            $last_call = $check->last_call_at;
            $duration = $check->duration;
            $time = Carbon::createFromTimeString($last_call);
            $time = $time->addMinutes($duration);
            $now = Carbon::now();
            if ($now > $time) {
                return true;
            }

            return false;
        }
        Cache::create(['end_point' => $end_point, 'last_call_at' => now(), 'duration' => 1440]);

        return true;
    }
}

if (! function_exists('update_expiration')) {
    function update_expiration($end_point)
    {
        $end_point = Cache::where('end_point', $end_point)->first();
        $end_point->last_call_at = now();
        $end_point->save();
    }
}

if (! function_exists('update_data')) {
    function update_data($table, $data, $unique_fields = [])
    {
        DB::table($table)->upsert($data, $unique_fields);
    }
}

if (! function_exists('update_live')) {
    function update_live($data)
    {
        DB::table('lives')->delete();
        DB::table('lives')->insert($data);
    }
}
