<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Models\Favorite;
use App\Repositories\BaseRepository;
use function auth;
use Exception;
use Illuminate\Support\Facades\DB;

class FavoriteRepository extends BaseRepository
{
    //Define the model
    public function model()
    {
        return Favorite::class;
    }

    //Create new favorite
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            return parent::create([
                'user_id' => auth()->user()->id,
                'league_id' => $data['league_id'] ?? null,
                'team_id' => $data['team_id'] ?? null,
                'country_id' => $data['country_id'] ?? null,
            ]);
        });
        //Throw error exception
        throw new GeneralException('Error');
    }

    /**
     * remove item from favourite
     *
     * @param  int  $id
     * @return bool
     */
    public function remove($id)
    {
        try {
            Favorite::where('id', $id)->delete();

            return true;
        } catch (GeneralException $e) {
            throw new GeneralException('server error');
        }
    }

    /**
     * get favourite
     *
     * @return mixed
     */
    public function index()
    {
        $fav = Favorite::with(['country', 'league', 'team'])
            ->where('user_id', auth()->user()->id)->get();

        return $fav;
    }
}
