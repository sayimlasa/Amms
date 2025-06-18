<?php

namespace App\Http\Requests\Settings\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademiYearRequest extends FormRequest
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
                // 'unique:academic_years,name',
            ],
            'start_at' => [
                'required',
                'date_format:Y-m-d',
            ],
            'end_at' => [
                'required',
                'date_format:Y-m-d',
            ],
            'active' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
