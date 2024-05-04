<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderAssignRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'agent_name' => 'required|string',
        ];
    }
}
