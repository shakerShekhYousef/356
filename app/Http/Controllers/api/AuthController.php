<?php

namespace App\Http\Controllers\api;

use App\Events\TokenFcmEvent;
use App\Events\UserSettingEvent;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\Auth\LoginRequest;
use App\Http\Requests\api\Auth\RegisterRequest;
use App\Repositories\api\UserRepository;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        return $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->userRepository->create($request->all());
            $token = JWTAuth::getFacadeRoot()->fromUser($user);
            //User settings event
            event(new UserSettingEvent($user->id));
            //Response
            return response()->json(['status' => 1, 'data' => ['user' => $user, 'token' => $token]], 201);
        } catch (GeneralException $exception) {
            return error_response($exception->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);
            if ($token = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addYear(7)->timestamp])) {
                $user = $request->user();
                //create or update fcm token
                $device_id = $request->device_id;
                $fcmToken = $request->fcm_token;
                //Fcm token event
                event(new TokenFcmEvent($user->id, $device_id, $fcmToken));
                //response
                return response()->json(
                    ['status' => 1, 'data' => ['user' => $user, 'token' => $token]], 200);
            } else {
                return response()->json(['status' => 0, 'Messages' => 'Invalid Data '], 401);
            }
        } catch (GeneralException $exception) {
            return error_response($exception->getMessage());
        }
    }
}
