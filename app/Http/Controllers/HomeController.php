<?php

namespace App\Http\Controllers;

use App\Models\AcAsset;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $acassets=AcAsset::all();
        //$working=AcAsset::where('status','working')->get();                                                                                                                                                                ');
        return view('home',compact('acassets'));
    }
}
