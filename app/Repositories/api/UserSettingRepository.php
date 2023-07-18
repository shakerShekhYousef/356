<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Models\UserSetting;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserSettingRepository extends BaseRepository
{
    public function model()
    {
        return UserSetting::class;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            return parent::create([
                'get_all_notifications' => $data['get_all_notifications'] ? 1 : 0,
                'night_node' => $data['night_node'] ? 1 : 0,
                'user_id' => auth('api')->user()->id,
            ]);
        });
        throw new GeneralException('Error');
    }

    public function update(UserSetting $userSetting, array $data)
    {
        return DB::transaction(function () use ($data, $userSetting) {
            $settings = $userSetting->update([
                'get_all_notifications' => isset($data['get_all_notifications']) ?? $userSetting->get_all_notifications,
                'night_node' => $data['night_node'] ?? $userSetting->night_node,
            ]);

            return $settings;
        });
    }
}
