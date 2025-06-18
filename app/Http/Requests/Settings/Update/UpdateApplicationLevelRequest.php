<?php

namespace App\Http\Requests\Settings\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationLevelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                // 'unique:application_levels,name',
            ],
            'nta_level' => [
                'string',
                'required',
                // 'unique:application_levels,nta_level',
            ],
            'campus_id' => 'required|array|min:1',
            'campus_id.*' => 'exists:campuses,id', // Ensure each campus_id exists in the campuses table
            'active' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
