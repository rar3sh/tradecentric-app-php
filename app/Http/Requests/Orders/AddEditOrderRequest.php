<?php

namespace App\Http\Requests\Orders;

use App\Http\Requests\AppRequest;

class AddEditOrderRequest extends AppRequest
{
    public function rules(): array
    {
        return [
            'buyer_name' => 'required|string|min:5',
            'total' => 'required|integer|min:0',
        ];
    }
}
