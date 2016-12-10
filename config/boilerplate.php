<?php

return [

    'sign_up' => [
        'release_token' => env('SIGN_UP_RELEASE_TOKEN'),
        'validation_rules' => [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]
    ],

    'login' => [
        'validation_rules' => [
            'email' => 'required|email',
            'password' => 'required'
        ]
    ],

    'forgot_password' => [
        'validation_rules' => [
            'email' => 'required|email'
        ]
    ],

    'reset_password' => [
        'release_token' => env('PASSWORD_RESET_RELEASE_TOKEN', false),
        'validation_rules' => [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]
    ],

    'edit' => [
        'validation_rules' => [
            'name' => 'sometimes|filled',
            'email' => 'sometimes|email'
        ]
    ],

    'chatcreate' => [
        'validation_rules' => [
            'name' => 'required'
        ]
    ],

    'messagecreate' => [
        'validation_rules' => [
            'message' => 'required'
        ]
    ],

];
