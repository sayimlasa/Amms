<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
             
            'name' => [
                'string',
                'required',
            ],
    
            'mobile' => [
                'required',
                'nullable',
                'string',
                'min:9',
            ],
            'campus_id' => [
                'required',
                'integer',
            ],
            'email' => [
                'required',
                'unique:users,email,' . $this->route('user')->id,  // Correct use of the user ID in the URL
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

