<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use DB;
use App\Api\V1\Requests\MessageCreateRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MessageController extends Controller
{
    public function get(Request $request, JWTAuth $JWTAuth, $id)
    {
        $limit = $request->input('limit');

        $messages = DB::table('messages')
            ->select('id','user_id','chat_id','message','created_at')
            ->where('chat_id','=',$id)
            ->paginate($limit ? $limit : 15);

        foreach ($messages as $message) {
            $messageuser = DB::table('users')
                ->select('id','name')
                ->where('id','=',$message->user_id)
                ->first();
            $message->user = $messageuser;
        }
        

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

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
