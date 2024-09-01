<?php

namespace App\Http\Requests\Orders;

use App\Http\Requests\AppRequest;

class OrderFilterRequest extends AppRequest
{
    public function rules(): array
    {
        return [
            'perPage' => 'integer|min:1',
            'page' => 'integer|min:1',
            'order_number' => 'sometimes|string|nullable',
            'buyer_name' => 'sometimes|string|nullable',
            'total_minimum' => 'sometimes|integer|nullable',
            'created_after' => 'date|nullable',
        ];
    }
}
