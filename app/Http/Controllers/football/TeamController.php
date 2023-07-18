<?php

namespace App\Http\Controllers\football;

use App\Http\Controllers\Controller;
use App\Services\FootBallCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
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
     * get available teams in a league and season
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'league' => 'required|exists:leagues,id',
            'season' => 'required|exists:seasons,year',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 500);
        }
        $teams = $this->api_request->teams($request['league'], $request['season']);

        return response()->json(['status' => 1, 'data' => $teams]);
    }
}
