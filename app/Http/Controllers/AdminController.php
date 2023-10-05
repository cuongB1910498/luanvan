<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use APP\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Facade\FlareClient\View;
use Validator;

use Mews\Captcha\Captcha;
use Symfony\Contracts\Service\Attribute\Required;

session_start();

class AdminController extends Controller
{
    public function AuthAdmin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/admin-dashboard');
        }else{
            abort(404);
        }
    }
    public function dashboard(){
        if(Session::get('admin_id')){
            return view('admin.pages.home');
        }else{
            return Redirect::to('/adminlogin');
        }
        
    }

    public function login(){
        return view('admin.login');
    }

    public function admin_login_process(Request $request){
        $request->validate([
           'username'=> 'required',
           'password'=> 'required',
           'captcha' => 'required|captcha',
        ]);
        echo $username = $request->username;
        echo $password = md5($request->password);

        $result = DB::table('users')->where('username', $username)->where('password', $password)->first();
        print_r($result);
        
        if($result){
            Session::put('admin_name', 'admin');
            Session::put('admin_id', $result->id_user);
            return Redirect::to('/admin-dashboard');
        }else{
            return Redirect::to('/adminlogin')->with('msg', 'username or password was not correct!');;
        }
        
    }

    public function logout(){
        $this->AuthAdmin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/adminlogin');
    }
    
    public function add_station(){
        $this->AuthAdmin();
        $district = DB::table('tbl_district')
        ->join('tbl_province', 'tbl_district.id_province', '=', 'tbl_province.id_province')
        ->get();
        return view('admin.pages.addstation' , ['district'=>$district]);
    }

    public function add_station_process(Request $request){
        $this->AuthAdmin();
        $data = array();
        $data['station_name'] = $request->station_name;
        $data['address'] = $request->address;
        $data['is_main'] = $request->is_main;
        $data['id_district'] = $request->id_district;

        //print_r($data);
        $result = DB::table('tbl_post_station')->insert($data);
        if($result){
            Session::put('msg_add_station', 'Thêm Thành Công!');
            return Redirect::to('/add-station');
        }else{
            Session::put('msg_add_station', 'Đã có lỗi xảy ra');
        }
    }

    public function station_list(){
        $this->AuthAdmin();
        $get_province = DB::table('tbl_province')->get();
        $get_station = DB::table('tbl_post_station')
        ->join('tbl_district', 'tbl_post_station.id_district', '=', 'tbl_district.id_district')
        ->join('tbl_province', 'tbl_district.id_province', '=', 'tbl_province.id_province')
        ->get();
        return view('admin.pages.stationlistTable', ['get_province'=>$get_province, 'get_station'=>$get_station]);
    }

    public function station_detail($id_station){
        $this->AuthAdmin();
        $get_staff = DB::table('staff')->where('id_station', $id_station)
            ->join('tbl_posisions', 'tbl_posisions.id_posision', '=', 'staff.id_posision')
            ->get();
        $get_station = DB::table('tbl_post_station')
            ->where('id_station', $id_station)
            ->first();
        return view('admin.pages.stationdetail', ['get_staff'=>$get_staff, 'get_station'=>$get_station]);
    }

    public function edit_staff($id_staff){
        $this->AuthAdmin();
        $get_staff = DB::table('staff')->where('id_staff', $id_staff)->first();
        $get_station = DB::table('tbl_post_station')->get();
        $get_posison = DB::table('tbl_posisions')->get();
        return view('admin.pages.editstaff' ,['get_staff'=>$get_staff, 'get_station'=> $get_station, 'get_posision'=>$get_posison]);
    }

    public function edit_staff_process(Request $request, $id_staff){
        $this->AuthAdmin();
        $data = array();
        $data['staff_name']=$request->staff_name;
        $data['staff_phone']=$request->staff_phone;
        $data['staff_email']=$request->staff_email;
        $data['id_station']=$request->id_station;
        $data['id_posision']=$request->id_posision;

        // print_r($data);
        $result = DB::table('staff')->where('id_staff', $id_staff)->update($data);
        if($result){
            Session::put('msg_update', 'Cập Nhật Thành Công!');
            return Redirect::to('/station/'.$request->id_station);
        }
    }

    public function add_truck(){
        $this->AuthAdmin();
        $get_all_truck = DB::table('tbl_truck')->get();
        $get_driver = DB::table('staff')
            ->join('tbl_posisions', 'tbl_posisions.id_posision', '=', 'staff.id_posision')
            ->where('tbl_posisions.id_posision', 11)
            ->get();
        return view('admin.pages.addtruck', ['get_all_truck'=>$get_all_truck, 'get_driver'=>$get_driver]);
    }

    public function addTruckProcess(Request $request){
        $data = array();
        $data['bks'] = $request->bks;
        $data['start_point'] = $request->start_point;
        $data['end_point'] = $request->end_point;
        $data['id_truck_status'] = 1;
        $result = DB::table('tbl_truck')->insert($data);
        return Redirect::to('/add-truck')->with('success', 'Complete!');
    }

    public function editTruck($id_truck){
        $get_truck = DB::table('tbl_truck')->where('id_truck', $id_truck)->first();
        $get_driver = DB::table('staff')
            ->join('tbl_posisions', 'tbl_posisions.id_posision', '=', 'staff.id_posision')
            ->where('tbl_posisions.id_posision', 11)
            ->get();
        return view('admin.pages.edittruck', ['get_truck'=>$get_truck, 'get_driver'=>$get_driver]);
    }

    public function updateTruckProcess(Request $request, $id_truck){
        $data = array();
        if($request->id_staff == 'none'){
            $id_staff = 0;
        }else{
            $id_staff = $request->id_staff;
        }
        $data['bks'] = $request->bks;
        $data['start_point'] = $request->start_point;
        $data['end_point'] = $request->end_point;
        $data['id_staff'] = $id_staff;

        $result = DB::table('tbl_truck')->where('id_truck', $id_truck)->update($data);
        return Redirect::to('/add-truck')->with('success', 'Complete!');
    }

    public function deleteTruck($id_truck){
        $result = DB::table('tbl_truck')->where('id_truck',$id_truck)->delete();
        return Redirect::to('/add-truck')->with('delete_success', 'Delete Complete!');
    }

    public function trucksDetail(){
        $get_all_truck = DB::table('tbl_truck')
            ->join('truck_status', 'truck_status.id_truck_status', '=', 'tbl_truck.id_truck_status')
            ->get();
        return view('admin.pages.trucksdetail', ['get_all_truck'=>$get_all_truck]);
    }

    public function showtruckDetail($id_truck){
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $get_truck_log = DB::table('truck_log')
            ->join('tbl_post_station', 'tbl_post_station.id_station', '=', 'truck_log.id_station')
            ->join('staff', 'staff.id_staff', '=', 'truck_log.id_staff')
            ->where('thoi_gian', $now)
            ->get();
        return view('admin.pages.showtruckdetails', ['now'=>$now, 'get_truck_log'=>$get_truck_log]);
    }

    public function reloadCaptcha(){
        return response()->json(['captcha'=>captcha_img()]);
    }
}