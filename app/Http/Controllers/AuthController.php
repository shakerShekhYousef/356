<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * login using facebook or google
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'facebook_id' => 'nullable|unique:users,facebook_id',
            'google_id' => 'nullable|unique:users,google_id',
            'image' => 'nullable',
            'name' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 500);
        }
        if ($request['facebook_id'] == null && $request['google_id'] == null) {
            return response()->json(['status' => 0, 'message' => 'login error'], 500);
        }
        if ($request['google_id'] != null) {
            $user = User::where('google_id', $request['google_id'])->first();
            if ($user != null) {
                Auth::login($user);
                $token = $user->createToken('api_token')->plainTextToken;

                return response()->json(['status' => 1, 'message' => 'success', 'data' => ['user' => $user, 'token' => $token]]);
            } else {
                $data = [
                    'name' => $request['name'],
                    'google_id' => $request['google_id'],
                    'email' => $request['email'],
                ];
                if ($request['image'] != null) {
                    $data['image'] = $request['image'];
                }
                $user = User::create($data);
                if ($user) {
                    Auth::login($user);
                    $token = $user->createToken('api_token')->plainTextToken;

                    return response()->json(['status' => 1, 'message' => 'success', 'data' => ['user' => $user, 'token' => $token]]);
                }
            }
        } elseif ($request['facebook_id'] != null) {
            $user = User::where('facebook_id', $request['facebook_id'])->first();
            if ($user != null) {
                Auth::login($user);
                $token = $user->createToken('api_token')->plainTextToken;

                return response()->json(['status' => 1, 'message' => 'success', 'data' => ['user' => $user, 'token' => $token]]);
            } else {
                $data = [
                    'name' => $request['name'],
                    'facebook_id' => $request['facebook_id'],
                    'email' => $request['email'],
                ];
                if ($request['image'] != null) {
                    $data['image'] = $request['image'];
                }
                $user = User::create($data);
                if ($user) {
                    Auth::login($user);
                    $token = $user->createToken('api_token')->plainTextToken;

                    return response()->json(['status' => 1, 'message' => 'success', 'data' => ['user' => $user, 'token' => $token]]);
                }
            }
        }

        return response()->json(['status' => 0, 'message' => 'server error'], 500);
    }

    /**
     * log user out
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['status' => 1, 'message' => 'success']);
    }
}
