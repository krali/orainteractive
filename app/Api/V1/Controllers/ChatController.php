<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Chat;
use DB;
use App\Api\V1\Requests\ChatCreateRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ChatController extends Controller
{
    public function get(Request $request, JWTAuth $JWTAuth)
    {
        $q = $request->input('q');
        $limit = $request->input('limit');

        $chats = DB::table('chats')
            ->select('id','user_id','name','created_at')
            ->where('name','like','%'.$q.'%')
            ->paginate($limit ? $limit : 15);

        foreach ($chats as $chat) {
            $chatuser = DB::table('users')
                ->select('id','name')
                ->where('id','=',$chat->user_id)
                ->first();
            $chat->user = $chatuser;

            $lastmessage = DB::table('messages')
                ->select('id','user_id','chat_id','message','created_at')
                ->where('chat_id','=',$chat->id)
                ->latest()
                ->first();

            if(isset($lastmessage)){
                $messageuser = DB::table('users')
                    ->select('id','name')
                    ->where('id','=',$lastmessage->user_id)
                    ->first();
                $lastmessage->user = $messageuser;
            }

            $chat->lastmessage = $lastmessage;
        }

        return response()->json([
            'success' => true,
            'data' => $chats
        ]);
    }

    public function post(ChatCreateRequest $request, JWTAuth $JWTAuth)
    {
        $user = JWTAuth::parseToken()->toUser();
        $token = JWTAuth::fromUser($user);

        $chat = new Chat;
        $chat->name = $request->name;
        $chat->user_id = $user->id;

        if($chat->save()){
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $chat->id,
                    'user_id' => $user->id,
                    'name' => $chat->name,
                    'created' => $chat->created_at,
                    'user'=>[
                        'id' => $user->id,
                        'name' => $user->name
                    ],
                    'last_message' => null
                ],
            ]);
        }
    }
}
