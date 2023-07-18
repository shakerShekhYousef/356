<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Favorite\CreateFavoriteRequest;
use App\Repositories\api\FavoriteRepository;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    protected $favoriteRepo;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepo = $favoriteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->favoriteRepo->index();

        return success_response($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateFavoriteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFavoriteRequest $request)
    {
        $fav = $this->favoriteRepo->create($request->all());

        return success_response($fav);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->favoriteRepo->remove($id);

        return success_response();
    }
}
