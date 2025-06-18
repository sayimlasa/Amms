<?php

namespace App\Http\Requests\Settings\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgrammeRequest extends FormRequest
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
            'iaa_code' => 'required|string|max:10',
            'tcu_code' => 'nullable|string|max:10',
            'nacte_code' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
            'short' => 'required|string|max:10',
            'campus_id' => 'required|array|min:1',
            'campus_id.*' => 'exists:campuses,id', // Ensure each campus_id exists in the campuses table
            'intake_id' => 'required|array|min:1',
            'intake_id.*' => 'exists:intakes,id', // Ensure each intake_id exists in the intakes table
            'application_level_id' => 'required|exists:application_levels,id', // Assuming this references the 'application_levels' table
            'computing' => 'nullable|boolean', // Validating boolean (0 or 1)
            'active' => 'nullable|boolean', // Validating boolean (0 or 1)
        ];
    }

    public function attributes()
    {
        return [
            'iaa_code' => 'IAA Code',
            'tcu_code' => 'TCU Code',
            'nacte_code' => 'NACTE Code',
            'name' => 'Program Name',
            'short' => 'Short Name',
            'campus_id' => 'Campuses',
            'intake_id' => 'Intakes',
            'application_level_id' => 'Application Level',
            'computing' => 'Computing',
            'active' => 'Active Status',
        ];
    }
}
