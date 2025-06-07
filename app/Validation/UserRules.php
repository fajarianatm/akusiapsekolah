<?php

namespace App\Validation;

use App\Models\UserModel;


class UserRules
{


    public function validateUser(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('email', $data['email'])->first();

        if (!$user)
            return false;

        return  password_verify($data['password'], $user['password']);
    }

    public function verifikasiData(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('email', $data['email'])->first();

        if (!$user)
            return false;
        if ($user['aktivasiKode'] == $data['aktivasiKode']) {
            return true;
        } else {
            return false;
        }
    }
}
