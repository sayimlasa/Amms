<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
 
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'campus_create',
            ],
            [
                'id'    => 18,
                'title' => 'campus_edit',
            ],
            [
                'id'    => 19,
                'title' => 'campus_show',
            ],
            [
                'id'    => 20,
                'title' => 'campus_delete',
            ],
            [
                'id'    => 21,
                'title' => 'campus_access',
            ],
            [
                'id'    => 22,
                'title' => 'faculty_create',
            ],
            [
                'id'    => 23,
                'title' => 'faculty_edit',
            ],
            [
                'id'    => 24,
                'title' => 'faculty_show',
            ],
            [
                'id'    => 25,
                'title' => 'faculty_delete',
            ],
            [
                'id'    => 26,
                'title' => 'faculty_access',
            ],
            [
                'id'    => 27,
                'title' => 'award_create',
            ],
            [
                'id'    => 28,
                'title' => 'award_edit',
            ],
            [
                'id'    => 29,
                'title' => 'award_show',
            ],
            [
                'id'    => 30,
                'title' => 'award_delete',
            ],
            [
                'id'    => 31,
                'title' => 'award_access',
            ],
            [
                'id'    => 32,
                'title' => 'academic_year_create',
            ],
            [
                'id'    => 33,
                'title' => 'academic_year_edit',
            ],
            [
                'id'    => 34,
                'title' => 'academic_year_show',
            ],
            [
                'id'    => 35,
                'title' => 'academic_year_delete',
            ],
            [
                'id'    => 36,
                'title' => 'academic_year_access',
            ],
            [
                'id'    => 37,
                'title' => 'intake_create',
            ],
            [
                'id'    => 38,
                'title' => 'intake_edit',
            ],
            [
                'id'    => 39,
                'title' => 'intake_show',
            ],
            [
                'id'    => 40,
                'title' => 'intake_delete',
            ],
            [
                'id'    => 41,
                'title' => 'intake_access',
            ],
            [
                'id'    => 42,
                'title' => 'study_year_create',
            ],
            [
                'id'    => 43,
                'title' => 'study_year_edit',
            ],
            [
                'id'    => 44,
                'title' => 'study_year_show',
            ],
            [
                'id'    => 45,
                'title' => 'study_year_delete',
            ],
            [
                'id'    => 46,
                'title' => 'study_year_access',
            ],
            [
                'id'    => 47,
                'title' => 'semester_create',
            ],
            [
                'id'    => 48,
                'title' => 'semester_edit',
            ],
            [
                'id'    => 49,
                'title' => 'semester_show',
            ],
            [
                'id'    => 50,
                'title' => 'semester_delete',
            ],
            [
                'id'    => 51,
                'title' => 'semester_access',
            ],
            [
                'id'    => 52,
                'title' => 'depertment_create',
            ],
            [
                'id'    => 53,
                'title' => 'depertment_edit',
            ],
            [
                'id'    => 54,
                'title' => 'depertment_show',
            ],
            [
                'id'    => 55,
                'title' => 'depertment_delete',
            ],
            [
                'id'    => 56,
                'title' => 'depertment_access',
            ],
            [
                'id'    => 57,
                'title' => 'program_create',
            ],
            [
                'id'    => 58,
                'title' => 'program_edit',
            ],
            [
                'id'    => 59,
                'title' => 'program_show',
            ],
            [
                'id'    => 60,
                'title' => 'program_delete',
            ],
            [
                'id'    => 61,
                'title' => 'program_access',
            ],
            [
                'id'    => 62,
                'title' => 'delivery_mode_create',
            ],
            [
                'id'    => 63,
                'title' => 'delivery_mode_edit',
            ],
            [
                'id'    => 64,
                'title' => 'delivery_mode_show',
            ],
            [
                'id'    => 65,
                'title' => 'delivery_mode_delete',
            ],
            [
                'id'    => 66,
                'title' => 'delivery_mode_access',
            ],
            [
                'id'    => 67,
                'title' => 'module_category_create',
            ],
            [
                'id'    => 68,
                'title' => 'module_category_edit',
            ],
            [
                'id'    => 69,
                'title' => 'module_category_show',
            ],
            [
                'id'    => 70,
                'title' => 'module_category_delete',
            ],
            [
                'id'    => 71,
                'title' => 'module_category_access',
            ],
            [
                'id'    => 72,
                'title' => 'module_create',
            ],
            [
                'id'    => 73,
                'title' => 'module_edit',
            ],
            [
                'id'    => 74,
                'title' => 'module_show',
            ],
            [
                'id'    => 75,
                'title' => 'module_delete',
            ],
            [
                'id'    => 76,
                'title' => 'module_access',
            ],
            [
                'id'    => 77,
                'title' => 'examination_access',
            ],
            [
                'id'    => 78,
                'title' => 'grade_create',
            ],
            [
                'id'    => 79,
                'title' => 'grade_edit',
            ],
            [
                'id'    => 80,
                'title' => 'grade_show',
            ],
            [
                'id'    => 81,
                'title' => 'grade_delete',
            ],
            [
                'id'    => 82,
                'title' => 'grade_access',
            ],
            [
                'id'    => 83,
                'title' => 'gpa_grade_range_create',
            ],
            [
                'id'    => 84,
                'title' => 'gpa_grade_range_edit',
            ],
            [
                'id'    => 85,
                'title' => 'gpa_grade_range_show',
            ],
            [
                'id'    => 86,
                'title' => 'gpa_grade_range_delete',
            ],
            [
                'id'    => 87,
                'title' => 'gpa_grade_range_access',
            ],
            [
                'id'    => 88,
                'title' => 'venue_create',
            ],
            [
                'id'    => 89,
                'title' => 'venue_edit',
            ],
            [
                'id'    => 90,
                'title' => 'venue_show',
            ],
            [
                'id'    => 91,
                'title' => 'venue_delete',
            ],
            [
                'id'    => 92,
                'title' => 'venue_access',
            ],
            [
                'id'    => 93,
                'title' => 'venues_allocation_create',
            ],
            [
                'id'    => 94,
                'title' => 'venues_allocation_edit',
            ],
            [
                'id'    => 95,
                'title' => 'venues_allocation_show',
            ],
            [
                'id'    => 96,
                'title' => 'venues_allocation_delete',
            ],
            [
                'id'    => 97,
                'title' => 'venues_allocation_access',
            ],
            [
                'id'    => 98,
                'title' => 'exam_type_create',
            ],
            [
                'id'    => 99,
                'title' => 'exam_type_edit',
            ],
            [
                'id'    => 100,
                'title' => 'exam_type_show',
            ],
            [
                'id'    => 101,
                'title' => 'exam_type_delete',
            ],
            [
                'id'    => 102,
                'title' => 'exam_type_access',
            ],
            [
                'id'    => 103,
                'title' => 'document_type_create',
            ],
            [
                'id'    => 104,
                'title' => 'document_type_edit',
            ],
            [
                'id'    => 105,
                'title' => 'document_type_show',
            ],
            [
                'id'    => 106,
                'title' => 'document_type_delete',
            ],
            [
                'id'    => 107,
                'title' => 'document_type_access',
            ],
            [
                'id'    => 108,
                'title' => 'students_profile_create',
            ],
            [
                'id'    => 109,
                'title' => 'students_profile_edit',
            ],
            [
                'id'    => 110,
                'title' => 'students_profile_show',
            ],
            [
                'id'    => 111,
                'title' => 'students_profile_delete',
            ],
            [
                'id'    => 112,
                'title' => 'students_profile_access',
            ],
            [
                'id'    => 113,
                'title' => 'staff_type_create',
            ],
            [
                'id'    => 114,
                'title' => 'staff_type_edit',
            ],
            [
                'id'    => 115,
                'title' => 'staff_type_show',
            ],
            [
                'id'    => 116,
                'title' => 'staff_type_delete',
            ],
            [
                'id'    => 117,
                'title' => 'staff_type_access',
            ],
            [
                'id'    => 118,
                'title' => 'staff_designation_create',
            ],
            [
                'id'    => 119,
                'title' => 'staff_designation_edit',
            ],
            [
                'id'    => 120,
                'title' => 'staff_designation_show',
            ],
            [
                'id'    => 121,
                'title' => 'staff_designation_delete',
            ],
            [
                'id'    => 122,
                'title' => 'staff_designation_access',
            ],
            [
                'id'    => 123,
                'title' => 'staff_profile_create',
            ],
            [
                'id'    => 124,
                'title' => 'staff_profile_edit',
            ],
            [
                'id'    => 125,
                'title' => 'staff_profile_show',
            ],
            [
                'id'    => 126,
                'title' => 'staff_profile_delete',
            ],
            [
                'id'    => 127,
                'title' => 'staff_profile_access',
            ],
            [
                'id'    => 128,
                'title' => 'staff_access',
            ],
            [
                'id'    => 129,
                'title' => 'ca_management_access',
            ],
            [
                'id'    => 130,
                'title' => 'ca_category_create',
            ],
            [
                'id'    => 131,
                'title' => 'ca_category_edit',
            ],
            [
                'id'    => 132,
                'title' => 'ca_category_show',
            ],
            [
                'id'    => 133,
                'title' => 'ca_category_delete',
            ],
            [
                'id'    => 134,
                'title' => 'ca_category_access',
            ],
            [
                'id'    => 135,
                'title' => 'ca_result_create',
            ],
            [
                'id'    => 136,
                'title' => 'ca_result_edit',
            ],
            [
                'id'    => 137,
                'title' => 'ca_result_show',
            ],
            [
                'id'    => 138,
                'title' => 'ca_result_delete',
            ],
            [
                'id'    => 139,
                'title' => 'ca_result_access',
            ],
            [
                'id'    => 140,
                'title' => 'assessment_mode_access',
            ],
            [
                'id'    => 141,
                'title' => 'curriculum_create',
            ],
            [
                'id'    => 142,
                'title' => 'curriculum_edit',
            ],
            [
                'id'    => 143,
                'title' => 'curriculum_show',
            ],
            [
                'id'    => 144,
                'title' => 'curriculum_delete',
            ],
            [
                'id'    => 145,
                'title' => 'curriculum_access',
            ],
            [
                'id'    => 146,
                'title' => 'apprenticeship_create',
            ],
            [
                'id'    => 147,
                'title' => 'apprenticeship_edit',
            ],
            [
                'id'    => 148,
                'title' => 'apprenticeship_show',
            ],
            [
                'id'    => 149,
                'title' => 'apprenticeship_delete',
            ],
            [
                'id'    => 150,
                'title' => 'apprenticeship_access',
            ],
            [
                'id'    => 151,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 152,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 153,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 154,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 155,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 156,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 157,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 158,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 159,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 160,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 161,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 162,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 163,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 164,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 165,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 166,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 167,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 168,
                'title' => 'main_setting_access',
            ],
            [
                'id'    => 169,
                'title' => 'modules_management_access',
            ],
            [
                'id'    => 170,
                'title' => 'examinations_result_access',
            ],
            [
                'id'    => 171,
                'title' => 'facilitator_create',
            ],
            [
                'id'    => 172,
                'title' => 'facilitator_edit',
            ],
            [
                'id'    => 173,
                'title' => 'facilitator_show',
            ],
            [
                'id'    => 174,
                'title' => 'facilitator_delete',
            ],
            [
                'id'    => 175,
                'title' => 'facilitator_access',
            ],
            [
                'id'    => 176,
                'title' => 'payment_access',
            ],
            [
                'id'    => 177,
                'title' => 'payment_type_create',
            ],
            [
                'id'    => 178,
                'title' => 'payment_type_edit',
            ],
            [
                'id'    => 179,
                'title' => 'payment_type_show',
            ],
            [
                'id'    => 180,
                'title' => 'payment_type_delete',
            ],
            [
                'id'    => 181,
                'title' => 'payment_type_access',
            ],
            [
                'id'    => 182,
                'title' => 'billing_create',
            ],
            [
                'id'    => 183,
                'title' => 'billing_edit',
            ],
            [
                'id'    => 184,
                'title' => 'billing_show',
            ],
            [
                'id'    => 185,
                'title' => 'billing_delete',
            ],
            [
                'id'    => 186,
                'title' => 'billing_access',
            ],
            [
                'id'    => 187,
                'title' => 'payment_status_create',
            ],
            [
                'id'    => 188,
                'title' => 'payment_status_edit',
            ],
            [
                'id'    => 189,
                'title' => 'payment_status_show',
            ],
            [
                'id'    => 190,
                'title' => 'payment_status_delete',
            ],
            [
                'id'    => 191,
                'title' => 'payment_status_access',
            ],
            [
                'id'    => 192,
                'title' => 'heslb_payment_create',
            ],
            [
                'id'    => 193,
                'title' => 'heslb_payment_edit',
            ],
            [
                'id'    => 194,
                'title' => 'heslb_payment_show',
            ],
            [
                'id'    => 195,
                'title' => 'heslb_payment_delete',
            ],
            [
                'id'    => 196,
                'title' => 'heslb_payment_access',
            ],
            [
                'id'    => 197,
                'title' => 'payment_transfer_type_create',
            ],
            [
                'id'    => 198,
                'title' => 'payment_transfer_type_edit',
            ],
            [
                'id'    => 199,
                'title' => 'payment_transfer_type_show',
            ],
            [
                'id'    => 200,
                'title' => 'payment_transfer_type_delete',
            ],
            [
                'id'    => 201,
                'title' => 'payment_transfer_type_access',
            ],
            [
                'id'    => 202,
                'title' => 'payments_transfer_create',
            ],
            [
                'id'    => 203,
                'title' => 'payments_transfer_edit',
            ],
            [
                'id'    => 204,
                'title' => 'payments_transfer_show',
            ],
            [
                'id'    => 205,
                'title' => 'payments_transfer_delete',
            ],
            [
                'id'    => 206,
                'title' => 'payments_transfer_access',
            ],
            [
                'id'    => 207,
                'title' => 'exam_number_create',
            ],
            [
                'id'    => 208,
                'title' => 'exam_number_edit',
            ],
            [
                'id'    => 209,
                'title' => 'exam_number_show',
            ],
            [
                'id'    => 210,
                'title' => 'exam_number_delete',
            ],
            [
                'id'    => 211,
                'title' => 'exam_number_access',
            ],
            [
                'id'    => 212,
                'title' => 'student_venue_allocation_create',
            ],
            [
                'id'    => 213,
                'title' => 'student_venue_allocation_edit',
            ],
            [
                'id'    => 214,
                'title' => 'student_venue_allocation_show',
            ],
            [
                'id'    => 215,
                'title' => 'student_venue_allocation_delete',
            ],
            [
                'id'    => 216,
                'title' => 'student_venue_allocation_access',
            ],
            [
                'id'    => 217,
                'title' => 'postponement_access',
            ],
            [
                'id'    => 218,
                'title' => 'postponement_type_create',
            ],
            [
                'id'    => 219,
                'title' => 'postponement_type_edit',
            ],
            [
                'id'    => 220,
                'title' => 'postponement_type_show',
            ],
            [
                'id'    => 221,
                'title' => 'postponement_type_delete',
            ],
            [
                'id'    => 222,
                'title' => 'postponement_type_access',
            ],
            [
                'id'    => 223,
                'title' => 'postponement_status_create',
            ],
            [
                'id'    => 224,
                'title' => 'postponement_status_edit',
            ],
            [
                'id'    => 225,
                'title' => 'postponement_status_show',
            ],
            [
                'id'    => 226,
                'title' => 'postponement_status_delete',
            ],
            [
                'id'    => 227,
                'title' => 'postponement_status_access',
            ],
            [
                'id'    => 228,
                'title' => 'exam_postponement_create',
            ],
            [
                'id'    => 229,
                'title' => 'exam_postponement_edit',
            ],
            [
                'id'    => 230,
                'title' => 'exam_postponement_show',
            ],
            [
                'id'    => 231,
                'title' => 'exam_postponement_delete',
            ],
            [
                'id'    => 232,
                'title' => 'exam_postponement_access',
            ],
            [
                'id'    => 233,
                'title' => 'semr_acdyr_post_create',
            ],
            [
                'id'    => 234,
                'title' => 'semr_acdyr_post_edit',
            ],
            [
                'id'    => 235,
                'title' => 'semr_acdyr_post_show',
            ],
            [
                'id'    => 236,
                'title' => 'semr_acdyr_post_delete',
            ],
            [
                'id'    => 237,
                'title' => 'semr_acdyr_post_access',
            ],
            [
                'id'    => 238,
                'title' => 'postponment_feedback_create',
            ],
            [
                'id'    => 239,
                'title' => 'postponment_feedback_edit',
            ],
            [
                'id'    => 240,
                'title' => 'postponment_feedback_show',
            ],
            [
                'id'    => 241,
                'title' => 'postponment_feedback_delete',
            ],
            [
                'id'    => 242,
                'title' => 'postponment_feedback_access',
            ],
            [
                'id'    => 243,
                'title' => 'irregularity_managment_access',
            ],
            [
                'id'    => 244,
                'title' => 'irregularity_status_create',
            ],
            [
                'id'    => 245,
                'title' => 'irregularity_status_edit',
            ],
            [
                'id'    => 246,
                'title' => 'irregularity_status_show',
            ],
            [
                'id'    => 247,
                'title' => 'irregularity_status_delete',
            ],
            [
                'id'    => 248,
                'title' => 'irregularity_status_access',
            ],
            [
                'id'    => 249,
                'title' => 'irregularity_create',
            ],
            [
                'id'    => 250,
                'title' => 'irregularity_edit',
            ],
            [
                'id'    => 251,
                'title' => 'irregularity_show',
            ],
            [
                'id'    => 252,
                'title' => 'irregularity_delete',
            ],
            [
                'id'    => 253,
                'title' => 'irregularity_access',
            ],
            [
                'id'    => 254,
                'title' => 'publish_exam_create',
            ],
            [
                'id'    => 255,
                'title' => 'publish_exam_edit',
            ],
            [
                'id'    => 256,
                'title' => 'publish_exam_show',
            ],
            [
                'id'    => 257,
                'title' => 'publish_exam_delete',
            ],
            [
                'id'    => 258,
                'title' => 'publish_exam_access',
            ],
            [
                'id'    => 259,
                'title' => 'payments_detail_create',
            ],
            [
                'id'    => 260,
                'title' => 'payments_detail_edit',
            ],
            [
                'id'    => 261,
                'title' => 'payments_detail_show',
            ],
            [
                'id'    => 262,
                'title' => 'payments_detail_delete',
            ],
            [
                'id'    => 263,
                'title' => 'payments_detail_access',
            ],
            [
                'id'    => 264,
                'title' => 'installment_create',
            ],
            [
                'id'    => 265,
                'title' => 'installment_edit',
            ],
            [
                'id'    => 266,
                'title' => 'installment_show',
            ],
            [
                'id'    => 267,
                'title' => 'installment_delete',
            ],
            [
                'id'    => 268,
                'title' => 'installment_access',
            ],
            [
                'id'    => 269,
                'title' => 'ca_total_create',
            ],
            [
                'id'    => 270,
                'title' => 'ca_total_edit',
            ],
            [
                'id'    => 271,
                'title' => 'ca_total_show',
            ],
            [
                'id'    => 272,
                'title' => 'ca_total_delete',
            ],
            [
                'id'    => 273,
                'title' => 'ca_total_access',
            ],
            [
                'id'    => 274,
                'title' => 'examsresult_create',
            ],
            [
                'id'    => 275,
                'title' => 'examsresult_edit',
            ],
            [
                'id'    => 276,
                'title' => 'examsresult_show',
            ],
            [
                'id'    => 277,
                'title' => 'examsresult_delete',
            ],
            [
                'id'    => 278,
                'title' => 'examsresult_access',
            ],
            [
                'id'    => 279,
                'title' => 'overall_result_create',
            ],
            [
                'id'    => 280,
                'title' => 'overall_result_edit',
            ],
            [
                'id'    => 281,
                'title' => 'overall_result_show',
            ],
            [
                'id'    => 282,
                'title' => 'overall_result_delete',
            ],
            [
                'id'    => 283,
                'title' => 'overall_result_access',
            ],
            [
                'id'    => 284,
                'title' => 'results_status_create',
            ],
            [
                'id'    => 285,
                'title' => 'results_status_edit',
            ],
            [
                'id'    => 286,
                'title' => 'results_status_show',
            ],
            [
                'id'    => 287,
                'title' => 'results_status_delete',
            ],
            [
                'id'    => 288,
                'title' => 'results_status_access',
            ],
            [
                'id'    => 289,
                'title' => 'semester_gpa_create',
            ],
            [
                'id'    => 290,
                'title' => 'semester_gpa_edit',
            ],
            [
                'id'    => 291,
                'title' => 'semester_gpa_show',
            ],
            [
                'id'    => 292,
                'title' => 'semester_gpa_delete',
            ],
            [
                'id'    => 293,
                'title' => 'semester_gpa_access',
            ],
            [
                'id'    => 294,
                'title' => 'my_profile_create',
            ],
            [
                'id'    => 295,
                'title' => 'my_profile_edit',
            ],
            [
                'id'    => 296,
                'title' => 'my_profile_show',
            ],
            [
                'id'    => 297,
                'title' => 'my_profile_delete',
            ],
            [
                'id'    => 298,
                'title' => 'my_profile_access',
            ],
            [
                'id'    => 299,
                'title' => 'profile_password_edit',
            ],
            [
                'id'     => 300,
                'title'  => 'region_access',
            ],
            [
                'id'     => 302,
                'title'   => 'region_create',
            ],
            [
                'id'     => 303,
                'title'  => 'region_edit',
            ],
            [
                'id'     => 304,
                'title'  => 'region_show',
            ],
            [
                'id'     => 305,
                'title'  => 'region_update',
            ],
            [
                'id'     => 306,
                'title'  => 'countries_access',
            ],
            [
                'id'     => 307,
                'title'  => 'countries_edit',
            ],
            [
                'id'     => 308,
                'title'  => 'countries_show',
            ],
            [
                'id'     => 309,
                'title'  => 'countries_create',
            ],
            [
                'id'     => 310,
                'title'  => 'countries_update',
            ],
            [
                'id'     => 311,
                'title'  => 'district_access',
            ],
            [
                'id'     => 312,
                'title'  => 'district_create',
            ],
            [
                'id'     => 313,
                'title'  => 'district_edit',
            ],
            [
                'id'     => 314,
                'title'  =>'district_show',
            ],
            [
                'id'     => 315,
                'title'  => 'district_update',
            ],
            [
                'id'     => 316,
                'title'  => 'nation_access',
            ],
            [
                'id'     => 317,
                'title'  => 'nation_edit',
            ],
            [
                'id'     => 318,
                'title'  =>'nation_show',
            ],
            [
                'id'     => 319,
                'title'  =>'nation_update',
            ],
            [
                'id'     => 320,
                'title'  =>'application_level_access',
            ],
            [
                'id'     => 321,
                'title'  =>'application_level_create',
            ],
            [
                'id'     => 322,
                'title'  =>'application_level_edit',
            ],
            [
                'id'     => 323,
                'title'  =>'application_level_show',
            ],
            [
                'id'     => 324,
                'title'  =>'application_level_update',
            ],
            [
                'id'     => 325,
                'title'  =>'application_categories_access',
            ],
            [
                'id'     => 326,
                'title'  =>'application_categories_create',
            ],
            [
                'id'     => 327,
                'title'  =>'application_categories_edit',
            ],
            [
                'id'     => 328,
                'title'  =>'application_categories_show',
            ],
            [
                'id'     => 329,
                'title'  =>'application_categories_update',
            ],
            [
                'id'     => 330,
                'title'  =>'application_windows_access',
            ],
            [
                'id'     => 331,
                'title'  =>'application_windows_create',
            ],
            [
                'id'     => 332,
                'title'  => 'application_windows_edit',
            ],
            [
                'id'     => 333,
                'title'  => 'application_windows_show',
            ],
            [
                'id'     => 334,
                'title'  => 'application_windows_update',
            ],
            [
                'id'     => 335,
                'title'  => 'applicants_user_access',
            ],
            [
                'id'     => 336,
                'title'  => 'applicants_user_create',
            ],
            [
                'id'     => 337,
                'title'  => 'applicants_user_edit',
            ],
            [
                'id'     => 338,
                'title'  => 'applicants_user_update',
            ],
            [
                'id'     => 339,
                'title'  => 'applicants_user_delete',
            ],
            [
                'id'     => 340,
                'title'  => 'applicants_user_show',
            ],
            [
                'id'     => 342,
                'title'  => 'site_setting_access',
            ],
            [
                'id'     => 343,
                'title'  => 'site_setting_access',
            ],
            [
                'id'     => 344,
                'title'  => 'site_setting_create',
            ],
            [
                'id'     => 345,
                'title'  => 'site_setting_edit',
            ],
            [
                'id'     => 346,
                'title'  => 'site_setting_show',
            ],
            [
                'id'     => 347,
                'title'  => 'site_setting_delete',
            ],
            [
                'id'     => 348,
                'title'  => 'site_setting_update',
            ],
            [
                'id'     => 349,
                'title'  => 'applicants_selection_access',
            ],
            [
                'id'     => 350,
                'title'  => 'applicants_selection_create',
            ],
            [
                'id'     => 351,
                'title'  => 'applicants_selection_edit',
            ],
            [
                'id'     => 352,
                'title'  => 'applicants_selection_update',
            ],
            [
                'id'     => 353,
                'title'  => 'applicants_selection_delete',
            ],
            [
                'id'     => 354,
                'title'  => 'applicants_selection_show',
            ],
            [
                'id'     => 355,
                'title'  => 'applicants_user_control_access',
            ],
            [
                'id'     => 356,
                'title'  => 'applicants_user_control_delete',
            ],
            [
                'id'     => 357,
                'title'  => 'applicants_user_control_create',
            ],
            [
                'id'     => 358,
                'title'  => 'applicants_user_control_edit',
            ],
            [
                'id'     => 359,
                'title'  => 'applicants_user_control_show',
            ],

        ];
        
        Permission::insert($permissions);
    }
}
