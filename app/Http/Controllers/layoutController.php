<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use APP\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class layoutController extends Controller
{
    public function howtoPack(){
        return view("pages.howtopack");
    }

    public function prohibitedList(){
        return view('pages.prohibitedList');
    }
}
