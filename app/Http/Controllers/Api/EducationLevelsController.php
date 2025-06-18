<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use Illuminate\Http\Request;

class EducationLevelsController extends Controller
{
    public function getEducationLevels($applicationCategoryId)
    {
        // Validate the applicationCategoryId to ensure it is a number
        if (!is_numeric($applicationCategoryId)) {
            return response()->json([
                'error' => 'Invalid application category ID provided.'
            ], 400);
        }

        // Fetch education levels related to the given application category
        $educationLevels = EducationLevel::whereHas('educationLevelCategories', function ($query) use ($applicationCategoryId) {
            $query->where('application_category_id', $applicationCategoryId);
        })->get();

        // Return education levels as a JSON response
        return response()->json([
            'success' => true,
            'data' => $educationLevels,
        ]);
    }
}
