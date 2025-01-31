<?php

namespace App\Http\Controllers;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LoginController
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function createUser(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $response = $this->loginService->createUser($data);

        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $response = $this->loginService->login($request->username, $request->password);

        return response()->json($response);
    }

}
