<?php

namespace App\Http\Controllers\football;

use App\Http\Controllers\Controller;
use App\Services\FootBallCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
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
     * get players
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function players(Request $request)
    {
        if ($request['team'] != null && $request['season'] != null) {
            return $this->team_players($request);
        }
        if ($request['league'] != null && $request['season'] != null) {
            return $this->league_players($request);
        }

        return response()->json(['status' => 0, 'message' => 'team or league field is required with season'], 500);
    }

    /**
     * get players in team and season
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function team_players(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team' => 'required|exists:teams,id',
            'season' => 'required|exists:seasons,year',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 500);
        }
        $players = $this->api_request->team_players($request['team'], $request['season']);

        return response()->json(['status' => 1, 'data' => $players]);
    }

    /**
     * get players in league and season
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function league_players(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'league' => 'required|exists:leagues,id',
            'season' => 'required|exists:seasons,year',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 500);
        }
        $players = $this->api_request->league_players($request['league'], $request['season']);

        return response()->json(['status' => 1, 'data' => $players]);
    }
}
