<?php

namespace App\Repositories;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;

class LoginRepository
{
    public function findUsernameWithPassword($username, $password)
    {
        $user = Login::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function createUser($data){
        return Login::create($data);
    }

}
