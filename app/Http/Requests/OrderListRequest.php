<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderListRequest extends FormRequest
{
    public function rules()
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

    public function authorize()
    {
        return true;
    }
}
