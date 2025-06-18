<?php

namespace App\Http\Controllers\Api;

use App\Models\Campus;
use App\Models\TamisemiList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TamisemiListController extends Controller
{
    public function tamisemilogin(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect Format',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the applicant by email
        $applicant = TamisemiList::where('username', $request->username)->first();

        // Check if applicant exists
        if (!$applicant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Index number does not exist',
            ], 404); // 404 Not Found
        }
        // Revoke all previous tokens
        $applicant->tokens()->delete();

        // Issue a token
        $token = $applicant->createToken('Personal Access Token')->plainTextToken;

        // Return success response with the token
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $applicant->id,
                'username' => $applicant->username,
                'email' => $applicant->email,
            ]
        ]);
    }
    public function index($username)
    {
        $records = TamisemiList::where('username',$username)->first();
        return response()->json([
            'data' => $records
        ]);
    }

    public function edit($username)
    {
        $record = TamisemiList::with('campus')->where('username', $username)->first();
        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return response()->json(['data' => $record]);
    }

    public function update(Request $request, $username)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'application_year' => 'required|digits:4',
            'programe_name' => 'required|string',
            'institution_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'required|string',
            'district' => 'required|string',
            'region' => 'required|string',
            'Next_of_kin_fullname' => 'required|string',
            'Next_of_kin_phone_number' => 'required|string',
            'Next_of_kin_email' => 'required|email',
            'Next_of_kin_address' => 'required|string',
            'Next_of_kin_region' => 'required|string',
            'relationship' => 'nullable|string',
            'sex' => 'required|in:MALE,FEMALE',
            'date_of_birth' => 'required|date',
        ]);
        $record = TamisemiList::where('username', $username)->first();
        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $record->update(array_merge($validated, ['confirm' => 1]));
        return response()->json(['message' => 'Record updated successfully', 'data' => $record->fullname]);
    }
    public function unconfirmArusha()
    {
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        $studentlist = TamisemiList::where('confirm', 0)->where('campus_id', $arushaCampus)->get();
        return view('Admission.Applicants.nactevet.unconfirm-tamisemilist',compact('studentlist'));
    }
    public function unconfirmBabati()
    {
        $arushaCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        $studentlist = TamisemiList::where('confirm', 0)->where('campus_id', $arushaCampus)->get();
        return view('Admission.Applicants.nactevet.unconfirm-tamisemilist',compact('studentlist'));

    }
    public function confirmArusha()
    {
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        $studentlist = TamisemiList::where('confirm', 1)->where('campus_id', $arushaCampus)->get();
        return view('Admission.Applicants.nactevet.confirm-tamisemilist',compact('studentlist'));

    }
    public function confirmBabati()
    {
        $arushaCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        $studentlist = TamisemiList::where('confirm', 1)->where('campus_id', $arushaCampus)->get();
        return view('Admission.Applicants.nactevet.confirm-tamisemilist',compact('studentlist'));

    }
}
