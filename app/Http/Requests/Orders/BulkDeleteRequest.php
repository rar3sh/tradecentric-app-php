<?php

namespace App\Http\Requests\Orders;

use App\Http\Requests\AppRequest;

class BulkDeleteRequest extends AppRequest
{
    public function rules(): array
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:orders,id'
        ];
    }

    public function messages(): array
    {
        $messages = [
            'ids.required' => 'Please select at least one order.',
        ];

        foreach ($this->get('ids') as $key => $value) {
            $messages['ids.' . $key . '.exists'] = "$value is not a valid id for order.";
        }

        return $messages;
    }
}
