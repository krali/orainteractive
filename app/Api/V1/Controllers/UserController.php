<?php

namespace App\Api\V1\Controllers;

use Request;
use App\User;
use App\Api\V1\Requests\EditRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends Controller
{
    public function view(JWTAuth $JWTAuth)
    {
        $user = JWTAuth::parseToken()->toUser();
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'token' => $token,
                'email' => $user->email,
                'name' => $user->name
            ]
        ]);
    }

    public function edit(EditRequest $request, JWTAuth $JWTAuth)
    {
        $user = JWTAuth::parseToken()->toUser();
        $token = JWTAuth::fromUser($user);

        $user->name = $request->name;
        $user->email = $request->email;

        if($user->save()){
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'token' => $token,
                    'email' => $user->email,
                    'name' => $user->name
                ]
            ]);
        }
    }
}
