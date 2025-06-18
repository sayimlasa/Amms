<?php

namespace App\Http\Controllers;

use App\Models\Primary_menu;
use App\Models\Submenu;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(){
        return view("web.index");
    }
    public function abstract(){
        return view("web.abstract", );
    }

    public function registration(){
 
        return view("web.register");
    }

    public function speakers(){
        
        return view("web.speakers");
    }
}
