<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
     
        public function authorize()
        {
            return Gate::allows('role_edit');
        }
    
        public function rules()
        {
            return [
                'title' => [
                    'string',
                    'required',
                    'unique:roles,title,' . $this->route('role')->id // Ignore the current record (role) during the update
                ],
                'permissions.*' => [
                    'integer',
                ],
                'permissions' => [
                    'required',
                    'array',
                ],
            ];
            
        }
}
