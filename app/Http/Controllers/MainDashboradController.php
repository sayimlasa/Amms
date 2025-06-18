<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApplicantInfoController;
use App\Models\ApplicantsInfo;
use App\Models\ApplicantsUser;
use App\Models\Campus;
use App\Models\Programme;
use Illuminate\Http\Request;

class MainDashboradController extends Controller
{

    public function index()
    {
        // Example data from models
        $totalCampuses = Campus::count();
        $totalPrograms = Programme::count();
        $totalApplicantsToday = ApplicantsUser::whereDate('created_at', today())->count();
        $totalApplicants = ApplicantsUser::count();

        // Male and Female applicants count
        //$maleApplicants = ApplicantsInfo::where('gender', 'male')->count();
        //$femaleApplicants = ApplicantsInfo::where('gender', 'female')->count();

        // Applicants per campus data
        // $campuses = Campus::withCount('applicants')->get();

        // Pass the data to the dashboard view
        return view('admin.dashboard.main', compact(
            'totalCampuses',
            'totalPrograms',
            'totalApplicantsToday',
            'totalApplicants',
            //  'maleApplicants',
            //  'femaleApplicants',
            //  'campuses'
        ));
    }
    //arusha campus
    public function indexMain()
    {
        return view('admin.dashboard.mainArushaReport');
    }
    //dar campus
    public function indexDar()
    {
        return view('admin.dashboard.darReport');
    }
    //babati campus
    public function indexBabati()
    {
        return view('admin.dashboard.babatiReport');
    }
    //dodoma campus
    public function indexDodoma()
    {
        return view('admin.dashboard.dodomaReport');
    }
    //songea campus
    public function indexSongea()
    {
        return view('admin.dashboard.songeaReport');
    }
    //polisi campus
    public function indexPolisi()
    {
        return view('admin.dashboard.polisiReport');
    }
    //magereza campus
    public function indexMagereza()
    {
        return view('admin.dashboard.magerezaReport');
    }
}
