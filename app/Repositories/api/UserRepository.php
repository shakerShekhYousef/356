<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\traits\UploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    use UploadFile;

    public function model()
    {
        return User::class;
    }

    //Create a new user
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            return parent::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'image' => isset($data['image']) ?
                    $this->UploadImage($data['image'], User_IMG_PATH.'/'.$data['name'])
                    : null,
            ]);
        });

        throw new GeneralException('Error');
    }
}
