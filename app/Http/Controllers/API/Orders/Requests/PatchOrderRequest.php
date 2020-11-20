<?php

namespace App\Http\Controllers\API\Orders\Requests;

use App\Http\Controllers\Requests\BaseRequest;

class PatchOrderRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'update' => 'required|array',
            'update.*.id' => 'required|integer|exists:orders',
            'update.*.deleted' => 'boolean',
            'update.*.status_id' => 'integer|exists:order_statuses,id',
            'update.*.products' => 'array',
            'update.*.products.*.id' => 'required|integer|exists:products',
            'update.*.products.*.quantity' => 'required|integer|min:1'
        ];
    }
}
