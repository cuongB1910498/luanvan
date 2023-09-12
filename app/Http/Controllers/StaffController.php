<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class StaffController extends Controller
{
    public function index(){
        $id_staff = Session::get('id_staff');
        if($id_staff){
            return view('staff.home');
        }else{
            return Redirect::to('/staff/login');
        }
    }

    public function login(){
        return view('staff/login');
    }

    public function logout(){
        Session::put('id_staff', null);
        Session::put('staff_name', null);
        Session::put('id_station', null);
        return Redirect::to('/staff/login');
    }
    
    public function login_process(Request $request){
        $staff_username = $request->staff_username;
        $staff_password = md5($request->staff_password);
        $result = DB::table('staff')->where('staff_username', $staff_username)->where('staff_password', $staff_password)->first();

        if($result){
            Session::put('id_staff', $result->id_staff);
            Session::put('staff_name', $result->staff_name);
            Session::put('id_station', $result->id_station)
            Session::put('msg_staff_login', 'Đăng nhập Thành Công');

            return Redirect::to('/staff/dashboard');
        }else{
            Session::put('staff_login_error', 'Tài Khoản hoặc mật khẩu không đúng!');
            return Redirect::to('/staff/login');
        }
    }

    public function staff_profile(){
        $get_staff_info = DB::table('staff')->where('id_staff', Session::get('id_staff'))->first();
        return view('staff.profile', ['staff_info'=>$get_staff_info]);
    }

    public function user_change(Request $request){
        $data = array();
        $data['staff_name'] = $request->staff_name;
        $data['staff_phone'] = $request->staff_phone;
        $data['Staff_email'] = $request->Staff_email;
        
        $result = DB::table('staff')->where('id_staff', Session::get('id_staff'))->update($data);
        if($result){
            Session::put('msg_update_info', 'Cập nhật thành công!');
            return Redirect::to('/staff-profile');
        }else{
            Session::put('msg_update_info', 'đã có lỗi xảy ra!');
            return Redirect::to('/staff/profile');
        }
    }

    public function setting(){
        $get_info = DB::table('staff')
            ->join('tbl_posisions', 'staff.id_posision', '=', 'tbl_posisions.id_posision')
            ->where('id_staff', Session::get('id_staff'))
            ->get();
        

        return view('staff.setting', ['info' => $get_info]);
    }

    public function change_password(Request $request){
        $get_user_info = DB::table('staff')->where('id_staff', Session::get('id_staff'))->first();
        $old_password = md5($request->old_password);
        $get_old_password = $get_user_info->staff_password;
        $new_password = $request->staff_password;
        $confirm_password = $request->confirm_password;
        if(($new_password == $confirm_password ) && ($old_password == $get_old_password)){
            $data = array();
            $data['staff_password'] = md5($new_password);
            Session::put('msg_change_password', 'Mật khẩu đã được thay đổi!');
            $update_password = DB::table('staff')->where('id_staff', Session::get('id_staff'))->update($data);
            return Redirect::to('/staff/setting');
        }else{
            Session::put('msg_change_password', 'đã có lỗi xảy ra!');
            return Redirect::to('/staff/setting');
        }

    }
}

