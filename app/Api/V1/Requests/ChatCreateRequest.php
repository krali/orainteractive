<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class ChatCreateRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.chatcreate.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
