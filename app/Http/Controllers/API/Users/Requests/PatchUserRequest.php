<?php

namespace App\Http\Controllers\API\Users\Requests;

use App\Http\Controllers\Requests\BaseRequest;

class PatchUserRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'update' => 'required|array',
            'update.*.id' => 'required|integer|exists:users',
            'update.*.name' => 'string|max:255',
            'update.*.email' => 'email|unique:users|max:255',
            'update.*.phone'
        ];
    }
}
