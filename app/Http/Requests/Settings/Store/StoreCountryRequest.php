<?php

namespace App\Http\Requests\Settings\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
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
                'unique:countries,code',
            ],
            'name' => [
                'string',
                'required',
                'unique:countries,name',
            ],
        ];
    }
}
