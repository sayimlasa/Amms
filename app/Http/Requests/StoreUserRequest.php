<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }
    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
          'password' => [
                'string',
                'required',
            ],
            'campus_id' => [
                'required',
                'integer',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
            'roles.*' => [
                'integer',
            ],
            'role_id' => [
                'array',
                'required',
            ],
        ];
    }
  
}
