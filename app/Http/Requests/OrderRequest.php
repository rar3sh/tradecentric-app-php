<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'buyer_name' => 'required|string|min:5',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
