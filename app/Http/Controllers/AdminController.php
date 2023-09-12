<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use APP\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
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
        $username = $request->username;
        $password = md5($request->password);

        $result = DB::table('users')->where('username', $username)->where('password', $password)->first();
        print_r($result);
        
       if($result){
        Session::put('admin_name', 'admin');
        Session::put('admin_id', $result->id_user);
        return Redirect::to('/admin-dashboard');
       }else{
        Session::put('msg', 'username or password was not correct!');
        return Redirect::to('/adminlogin');
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
}