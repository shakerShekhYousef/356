<?php

namespace App\Http\Controllers\football;

use App\Http\Controllers\Controller;
use App\Services\FootBallCache;

class CountryController extends Controller
{
    public $api_request;

    /**
     * constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_request = new FootBallCache();
    }

    /**
     * get countries
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = $this->api_request->countries();

        return response()->json(['status' => 1, 'data' => $countries]);
    }
}
