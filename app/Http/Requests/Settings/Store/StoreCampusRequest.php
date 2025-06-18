<?php

namespace App\Http\Requests\Settings\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampusRequest extends FormRequest
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
            'code' => [
                'string',
                'required',
                'unique:campuses,code',
            ],
            'name' => [
                'string',
                'required',
                'unique:countries,name', // Checks if the country name is unique in the countries table
            ],
            'country_id' => [
                'integer',
                'required',
                'exists:countries,id', // Ensures county_id exists in the countries table's id column
            ],
            'region_state_id' => [
                'integer',
                'required',
                'exists:regions_states,id', // Ensures county_id exists in the countries table's id column
            ],
            'district_id' => [
                'integer',
                'required',
                'exists:districts,id', // Ensures county_id exists in the countries table's id column
            ],
            'active' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
