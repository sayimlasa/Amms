<?php

namespace App\Http\Requests\Applicants\Store;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantsUserStoreRequest extends FormRequest
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
            'index_no' => 'required|regex:/^[A-Za-z0-9]{5}\/[A-Za-z0-9]{4}\/[A-Za-z0-9]{4}$/', // validation for the index number
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'mobile_no' => 'required|regex:/^0\d{9,14}$/', // updated regex pattern
            'application_category_id' => 'required|exists:application_categories,id',
            'campus_id' => 'required|exists:campuses,id',
            // 'academic_year_id' => 'required|exists:academic_years,id',
            'active' => 'boolean',
        ];
    }

    public function attributes()
    {
        return [
            'index_no' => 'Index Number',
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
