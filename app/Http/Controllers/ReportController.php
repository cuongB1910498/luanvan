<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
//session_start();
class ReportController extends Controller
{
    protected $today;
    public function __construct(){
        $this->today = Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m-d');
    }
        
    public function AuthStaff(){
        $id_staff = Session::get('id_staff');
        if($id_staff){
            return Redirect::to('/staff/');
        }else{
            abort(404);
        }
    }

    public function deliveryReport(){
        $id_staff = Session('id_staff');
        
        $get_report = DB::table('delivery_report')->where('id_staff', $id_staff)->where('report_date', $this->today)->first();
        if($get_report){
            return view('staff.deliveryreport', ['get_report'=>$get_report]);
        }else{
            $create_today = DB::table('delivery_report')->insert([
                'id_staff'=>$id_staff,
                'report_date'=>$this->today,
                'total_tracking'=>0,
                'total_amount'=>0,
                'complete'=>0,
            ]);
            $get_report = DB::table('delivery_report')->where('id_staff', $id_staff)->where('report_date', $this->today)->first();
            return view('staff.deliveryreport', ['get_report'=>$get_report]);
        }
        
    }

    public function masterReport(){
        return view('staff.masterreport');
    }
   
}
