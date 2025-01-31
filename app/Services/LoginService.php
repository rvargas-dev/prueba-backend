<?php

namespace App\Services;

use App\Repositories\LoginRepository;
use App\Models\Login;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

class LoginService {


    protected $loginRepository;

    public function __construct(LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    public function createUser(array $data): Login
    {
        $data['password'] = Hash::make($data['password']);
        return $this->loginRepository->createUser($data);
    }

    public function login($username, $password)
    {
        $user = $this->loginRepository->findUsernameWithPassword($username, $password);

        if (!$user) {
            return ['error' => 'Credenciales inválidas'];
        }

        $payload = [
            'sub' => $user->id,
            'username' => $user->username,
            'iat' => time(),
            'exp' => time() + 3600
        ];

        $secretKey = env('JWT_SECRET', 'clave_secreta_super_segura');
        $token = JWT::encode($payload, $secretKey, 'HS256');

        return ['message' => 'Login exitoso', 'token' => $token];
    }

}
