<?php

namespace App\Http\Controllers\Requests;

use \App\Requests\FormRequest;

class BaseRequest extends FormRequest
{
    public function getData(string $action)
    {
        $data = parent::getFormData()[$action];

        return $data;
    }
}
