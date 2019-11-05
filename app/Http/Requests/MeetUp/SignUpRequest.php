<?php

namespace App\Http\Requests\MeetUp;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|int',
            'quantity' => 'required|int',
        ];
    }
}
