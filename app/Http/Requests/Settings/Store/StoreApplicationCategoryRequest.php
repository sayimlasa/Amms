<?php

namespace App\Http\Requests\Settings\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationCategoryRequest extends FormRequest
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
                'unique:application_categories,name',
            ],
            'application_level_id' => [
                'integer',
                'required',
                'exists:application_levels,id',
            ],
            'education_level_id' => 'required|array|min:1',
            'education_level_id.*' => 'exists:education_levels,id', 
            'active' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
