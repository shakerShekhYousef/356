<?php

namespace App\Http\Controllers\football;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\Season;
use App\Services\FootBallCache;

class LeagueController extends Controller
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
     * get league list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = $this->api_request->leagues();

        return response()->json(['status' => 1, 'data' => $leagues]);
    }

    /**
     * get seasons list in a league
     *
     * @param  int  $league_id
     * @return \Illuminate\Http\Response
     */
    public function seasons($id)
    {
        $seasons = Season::where('league_id', $id)->get();

        return response()->json(['status' => 1, 'data' => $seasons]);
    }

    /**
     * get league details
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $league = League::find($id);
        if ($league == null) {
            return not_found_response('league not found');
        }

        return success_response($league);
    }
}
