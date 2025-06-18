<?php

namespace App\Http\Requests\Settings\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDistrictRequest extends FormRequest
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
                // 'unique:districts,name', // Checks if the country name is unique in the countries table
            ],

            'region_state_id' => [
                'integer',
                'required',
                'exists:regions_states,id', // Ensures county_id exists in the countries table's id column
            ],
        ];
    }
}
