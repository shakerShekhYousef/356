<?php

namespace App\Trait;

use Illuminate\Support\Facades\Http;

trait ApiTrait
{
    public function fixture_details($fixture)
    {
        $uri = env('FOOTBALL_API_URL');
        $host = env('FOOTBALL_API_HOST');
        $apiKey = env('SPORT_API_KEY');
        $response = Http::withHeaders([
            'x-rapidapi-host' => $host,
            'x-rapidapi-key' => $apiKey,
        ])->get($uri.'/events?fixture='.$fixture);

        return $response;
    }
}
