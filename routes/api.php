<?php

use App\Http\Controllers\api\FavouriteController;
use App\Http\Controllers\api\UserSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\football\CountryController;
use App\Http\Controllers\football\LeagueController;
use App\Http\Controllers\football\PlayerController;
use App\Http\Controllers\football\TeamController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});
Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', [\App\Http\Controllers\api\AuthController::class, 'login'])->name('api.login');
    Route::post('register', [\App\Http\Controllers\api\AuthController::class, 'register'])->name('api.register');
});
//Favorite api
Route::apiResource('/favorites', FavouriteController::class)->middleware('auth:api');
//User settings api
Route::apiResource('user_settings', UserSettingController::class)->middleware('auth:api');
//Dashboard api
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/leagues', [LeagueController::class, 'index']);
Route::get('/leagues/{id}', [LeagueController::class, 'show']);
Route::get('/seasons/{id}', [LeagueController::class, 'seasons']);
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/players', [PlayerController::class, 'players']);

Route::apiResource('user', UsersController::class)->middleware('auth');
