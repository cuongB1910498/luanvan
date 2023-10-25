<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class layoutController extends Controller
{
    public function howtoPack(){
        return view("pages.howtopack");
    }

    public function prohibitedList(){
        return view('pages.prohibitedList');
    }
}
