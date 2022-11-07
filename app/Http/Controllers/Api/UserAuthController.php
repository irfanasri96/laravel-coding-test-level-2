<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserAuthController extends BaseController
{
    public function register(UserRequest $request)
    {
        $input = $request->all();
        $user = User::create($input);
        $token = $user->createToken('Laravel Password Grant Client', [$input['role']])->accessToken;

        return $this->sendResponse(['token' => $token], 'Register successful.');
    }

    public function login(UserRequest $request)
    {
        $input = $request->all();
        $user = User::where(['username' => $input['username'], 'password' => $input['password'], 'role' => $input['role']])->firstOrFail();
        if(!$user) {
            return $this->sendError('Credential mismatched.',  ['Authentication Failure'], 401);
        }
        $token = $user->createToken('Laravel Password Grant Client', [$input['role']])->accessToken;

        return $this->sendResponse(['token' => $token], 'Login successful.');
    }
}
