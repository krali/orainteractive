<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'users'], function($api) {
        $api->post('register', 'App\Api\V1\Controllers\SignUpController@signUp');
        $api->post('login', 'App\Api\V1\Controllers\LoginController@login');
        // $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        // $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->group(['middleware' => 'jwt.auth'], function($api) {
            $api->get('me', 'App\Api\V1\Controllers\UserController@view');
            $api->put('me', 'App\Api\V1\Controllers\UserController@edit');
        });
    });

    $api->group(['prefix' => 'chats', 'middleware' => 'jwt.auth'], function($api) {
        $api->get('/', 'App\Api\V1\Controllers\ChatController@get');
        $api->post('/', 'App\Api\V1\Controllers\ChatController@post');

        $api->group(['prefix' => '{id}'], function($api) {
            $api->get('messages', 'App\Api\V1\Controllers\MessageController@get');
            $api->post('messages', 'App\Api\V1\Controllers\MessageController@post');
        });
    });

    $api->group(['middleware' => 'jwt.auth'], function($api) {

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
