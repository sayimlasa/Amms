<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Models\ApplicationLevel;
use App\Models\TutionFee;
use Illuminate\Http\Request;

class TutionfeeSettingController extends Controller
{
    public function paymentsetting()
    {
        $settings = TutionFee::all();
        return view('registrations.setting', compact('settings'));
    }
    public function createSetting()
    {
        $levels = ApplicationLevel::all();
        return view('registrations.create-setting', compact('levels'));
    }
    public function storeSetting(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'application_level_id' => 'required|integer|exists:application_levels,id',
            'amount'   => 'required|numeric|min:0',            
            'computing' => 'required|boolean',                  
        ]);
    
        // Store the validated data in the TutionFee model
        TutionFee::create([
            'level_id' => $validatedData['application_level_id'],
            'amount'   => $validatedData['amount'],
            'computing' => $validatedData['computing'],
        ]);
    
        // Redirect back with success message
        return redirect()->route('payment.setting')->with('success', 'Setting saved successfully!');
    }
    
   
public function editSetting($id)
{
    $levels = ApplicationLevel::all();
    $setting = TutionFee::findOrFail($id);
    return view('registrations.edit-setting', compact('setting', 'levels'));
}

public function updateSetting(Request $request, $id)
{
    $validatedData = $request->validate([
        'level_id' => 'required|integer|exists:application_levels,id',
        'amount' => 'required|numeric|min:0',
        //'computing' => 'required|boolean'
    ]);

    TutionFee::updateOrCreate(
        ['id' => $id],  // Find the record with the provided id
        [
            'level_id' => $validatedData['level_id'],  // Set the level_id
            'amount' => $validatedData['amount'],  // Set the amount
            'computing' => $request->computing,  // Set the computing flag
        ]
    );

    return redirect()->route('payment.setting')->with('success', 'Tution Fee updated successfully');
}
    // Add the delete method here
    public function deleteSetting($id)
    {
        // Find the setting by its id
        $setting = TutionFee::findOrFail($id);
        $setting->delete();
        // Redirect with success message
        return redirect()->route('payment.setting')->with('success', 'Tution Fee deleted successfully');
    }
}
