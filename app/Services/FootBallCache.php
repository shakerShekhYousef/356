<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Fixture;
use App\Models\League;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Trait\CachTrait;

class FootBallCache
{
    use CachTrait;

    public $uri;

    public $apiKey;

    public $host;

    /**
     * constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->uri = env('FOOTBALL_API_URL');
        $this->apiKey = env('SPORT_API_KEY');
        $this->host = env('FOOTBALL_API_HOST');
    }

    /**
     * get countries list
     *
     * @return \Illuminate\Http\Response
     */
    public function countries()
    {
        $check = $this->is_expired('countries');
        if ($check) {
            $this->update_endpoint('countries');
            $response = call_football_api('countries');
            $data = [];
            foreach ($response['response'] as $country) {
                array_push($data, $country);
            }
            update_data('countries', $data, ['code']);
        }
        $countries = Country::all();

        return $countries;
    }

    /**
     * get leagues list
     *
     * @return \Illuminate\Http\Response
     */
    public function leagues()
    {
        if ($this->is_expired('leagues')) {
            $this->update_endpoint('leagues');
            $response = call_football_api('leagues');
            $seasons = [];
            $leagues = [];
            foreach ($response['response'] as $league) {
                $country = Country::where('code', $league['country']['code'])->first();
                array_push($leagues, [
                    'country_id' => $country->id,
                    'id' => $league['league']['id'],
                    'name' => $league['league']['name'],
                    'type' => $league['league']['type'],
                    'logo' => $league['league']['logo'],
                ]);
                foreach ($league['seasons'] as $season) {
                    array_push($seasons, [
                        'league_id' => $league['league']['id'],
                        'year' => $season['year'],
                        'start_at' => $season['start'],
                        'end_at' => $season['end'],
                        'current' => $season['current'],
                    ]);
                }
            }
            update_data('seasons', $seasons, ['league_id', 'name']);
            update_data('leagues', $leagues, ['id']);
        }
        $leagues = League::all();

        return $leagues;
    }

    /**
     * get teams list in a league and season
     *
     * @param  int  $league
     * @param  int  $season
     * @return \Illuminate\Http\Response
     */
    public function teams($league, $season)
    {
        if ($this->is_expired('teams')) {
            $this->update_endpoint('teams');
            $response = call_football_api('teams?league='.$league.'&season='.$season);
            $teams = [];
            foreach ($response['response'] as $item) {
                $team = $item['team'];
                $country = Country::where('name', $team['country'])->first();
                array_push($teams, [
                    'country_id' => $country->id,
                    'id' => $team['id'],
                    'name' => $team['name'],
                    'code' => $team['code'],
                    'country' => $team['country'],
                    'founded' => $team['founded'],
                    'national' => $team['national'],
                    'logo' => $team['logo'],
                ]);
                update_data('teams', $teams, ['id']);
            }
        }
        $teams = Team::with(['country'])->get();

        return $teams;
    }

    /**
     * get live fixures
     *
     * @return \Illuminate\Http\Response
     */
    public function live_fixures()
    {
    }

    /**
     * get team players in a season
     *
     * @param  int  $team
     * @param int season
     * @return \Illuminate\Http\Response
     */
    public function team_players($team, $season)
    {
        $tm = Team::find($team);
        $seas = Season::where('year', $season)->first();
        if ($this->is_expired('team_players')) {
            $this->update_endpoint('team_players');
            $response = call_football_api('players?team='.$team.'&season='.$season);
            $players = [];
            foreach ($response['response'] as $item) {
                $player = $item['player'];
                $league = $item['statistics'][0]['league'];
                array_push($players, [
                    'id' => $player['id'],
                    'name' => $player['name'],
                    'firstname' => $player['firstname'],
                    'lastname' => $player['lastname'],
                    'age' => $player['age'],
                    'nationality' => $player['nationality'],
                    'height' => $player['height'],
                    'weight' => $player['weight'],
                    'injured' => $player['injured'],
                    'photo' => $player['photo'],
                    'birth_date' => $player['birth']['date'],
                    'birth_place' => $player['birth']['date'],
                    'birth_country' => $player['birth']['date'],
                    'team_id' => $tm->id,
                    'season_id' => $seas->id,
                    'league_id' => $league['id'],
                ]);
            }
            update_data('players', $players, ['id']);
        }
        $players = Player::with(['league', 'team', 'season'])->where('team_id', $team)
            ->where('season_id', $seas->id)->get();

        return $players;
    }

    /**
     * get players in a league
     *
     * @param  int  $league
     * @param  int  $season
     * @return \Illuminate\Http\Response
     */
    public function league_players($league, $season)
    {
        $lg = League::find($league);
        $seas = Season::where('year', $season)->first();
        if ($this->is_expired('league_players')) {
            $this->update_endpoint('league_players');
            $response = call_football_api('players?league='.$league.'&season='.$season);
            $players = [];
            foreach ($response['response'] as $item) {
                $player = $item['player'];
                $team = $item['statistics'][0]['team'];
                array_push($players, [
                    'id' => $player['id'],
                    'name' => $player['name'],
                    'firstname' => $player['firstname'],
                    'lastname' => $player['lastname'],
                    'age' => $player['age'],
                    'nationality' => $player['nationality'],
                    'height' => $player['height'],
                    'weight' => $player['weight'],
                    'injured' => $player['injured'],
                    'photo' => $player['photo'],
                    'birth_date' => $player['birth']['date'],
                    'birth_place' => $player['birth']['date'],
                    'birth_country' => $player['birth']['date'],
                    'team_id' => $team['id'],
                    'season_id' => $seas->id,
                    'league_id' => $lg->id,
                ]);
                update_data('players', $players, ['id']);
            }
        }
        $players = Player::with(['league', 'team', 'season'])->where('league_id', $league)
            ->where('season_id', $seas->id)->get();

        return $players;
    }

    /**
     * get live fixtures
     *
     * @return \Illuminate\Http\Response
     */
    public function live_fixtures()
    {
        if ($this->is_expired('fixtures')) {
            $this->update_endpoint('fixtures');
            $response = call_football_api('fixtures?live=all');
            $data = $response['response'];
            $fixtures = [];
            $ids = [];
            foreach ($data as $item) {
                $fixture = $item['fixture'];
                $ids[] = $fixture['id'];
                array_push($fixtures, [
                    'id' => $fixture['id'],
                    'referee' => $fixture['referee'],
                    'timezone' => $fixture['timezone'],
                    'timestamp' => $fixture['timestamp'],
                    'period_first' => $fixture['period']['first'],
                    'period_second' => $fixture['period']['second'],
                    'status_long' => $fixture['status']['long'],
                    'status_short' => $fixture['status']['short'],
                    'status_elapsed' => $fixture['status']['elapsed'],
                    'league_id' => $fixture['league']['id'],
                ]);
            }
            update_data('fixtures', $fixtures, ['id']);
            update_live($ids);
        }
        $fxitures = Fixture::with(['league'])->get();

        return $fixtures;
    }
}
