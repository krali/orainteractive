<?php

namespace App\Api\V1\Controllers;

use Request;
use App\User;
use App\Message;
use App\Api\V1\Requests\MessageCreateRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MessageController extends Controller
{
    // public function view(JWTAuth $JWTAuth)
    // {
    //     $user = JWTAuth::parseToken()->toUser();
    //     $token = JWTAuth::fromUser($user);

    //     return response()->json([
    //         'success' => true,
    //         'data' => [
    //             'id' => $user->id,
    //             'token' => $token,
    //             'email' => $user->email,
    //             'name' => $user->name
    //         ]
    //     ]);
    // }

    public function post(MessageCreateRequest $request, JWTAuth $JWTAuth, $id)
    {
        $user = JWTAuth::parseToken()->toUser();
        $token = JWTAuth::fromUser($user);

        $message = new Message;
        $message->message = $request->message;
        $message->user_id = $user->id;
        $message->chat_id = $id;

        if($message->save()){
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $message->id,
                    'chat_id' => $message->chat_id,
                    'user_id' => $message->user_id,
                    'message' => $message->message,
                    'created' => $message->created_at,
                    'user'=>[
                        'id' => $user->id,
                        'name' => $user->name
                    ]
                ]
            ]);
        }
    }
}
