<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

use APP\Http\Requests;
use Psy\Command\WhereamiCommand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
//use App\Imports\ImportTest;
use App\Imports\ImportTracking;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

session_start();
class locatedController extends Controller
{
    public function located(){
        return view('pages.located');
    }

    public function findLocated(Request $request){

        $inputString = $request->input('tracking');
        $strings = explode(',', $inputString);

        $results = [];

        foreach ($strings as $string) {
            $row = DB::table('located')
                ->where('id_tracking', $string)
                ->get();

            $results[$string] = $row;
        }

        return response()->json($results);
    
    }
}
