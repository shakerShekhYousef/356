<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\UserSetting\CreateUserSettingRequest;
use App\Models\UserSetting;
use App\Repositories\api\UserSettingRepository;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    protected $userSettingRepository;

    public function __construct(UserSettingRepository $userSettingRepository)
    {
        $this->userSettingRepository = $userSettingRepository;
    }

    public function index()
    {
        $settings = UserSetting::query()
            ->where('user_id', auth('api')->user()->id)
            ->with('user')
            ->first();

        return success_response($settings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserSettingRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserSettingRequest $request)
    {
        $user_id = auth()->user()->id;
        $setting = UserSetting::where('user_id', $user_id)->first();
        if ($setting) {
            $this->userSettingRepository->update($setting, $request->all());
        } else {
            $this->userSettingRepository->create($request->all());
        }

        return success_response($setting);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
    }
}
