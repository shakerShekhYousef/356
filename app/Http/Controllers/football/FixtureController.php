<?php

namespace App\Http\Controllers\football;

use App\Http\Controllers\Controller;
use App\Services\FootBallCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FixtureController extends Controller
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
     * get fixtures
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fixtures = $this->api_request->live_fixtures();

        return success_response($fixtures);
    }

    /**
     * get latest fixtures of league
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function league(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'season' => 'required|numeric',
            'league' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->first());
        }
    }
}
