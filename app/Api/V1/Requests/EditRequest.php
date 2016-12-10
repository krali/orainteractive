<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.edit.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
