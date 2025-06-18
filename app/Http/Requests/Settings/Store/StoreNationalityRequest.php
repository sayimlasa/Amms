<?php

namespace App\Http\Requests\Settings\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreNationalityRequest extends FormRequest
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
                'unique:nationalities,name', // Checks if the country name is unique in the countries table
            ],

            'country_id' => [
                'integer',
                'required',
                'exists:countries,id', // Ensures county_id exists in the countries table's id column
            ],
        ];
    }
}
