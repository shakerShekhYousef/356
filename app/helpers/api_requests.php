<?php

use Illuminate\Support\Facades\Http;

if (! function_exists('call_football_api')) {
    function call_football_api($link)
    {
        $uri = env('FOOTBALL_API_URL');
        $host = env('FOOTBALL_API_HOST');
        $apiKey = env('SPORT_API_KEY');
        $response = Http::withHeaders([
            'x-rapidapi-host' => $host,
            'x-rapidapi-key' => $apiKey,
        ])->get($uri.'/'.$link);

        return $response;
    }
}
