<?php

namespace App\Http\Requests\Applicants\Update;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantsUserUpdateRequest extends FormRequest
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
            'index_no' => 'string',
            'email' => 'email|unique:applicants_users,email,' . $this->route('applicants_user'),
            'password' => 'string|min:8',
            'mobile_no' => 'string',
            'application_category_id' => 'exists:application_categories,id',
            'campus_id' => 'exists:campuses,id',
            'acadmic_year_id' => 'exists:academic_years,id',
            'active' => 'boolean',
        ];
    }

    public function attributes()
    {
        return [
            'index_no' => 'Inde Number',
            'email' => 'Email',
            'password' => 'Password',
            'mobile_no' => 'Phone Number',
            'application_category_id' => 'Application Category',
            'campus_id' => 'Campus',
            'acadmic_year_id' => 'Academic Year',
            'active' => 'Active Statue',
        ];
    }
}
