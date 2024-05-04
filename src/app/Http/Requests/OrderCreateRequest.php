<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'delivery_time' => 'required|integer|max:100',
            'created_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
