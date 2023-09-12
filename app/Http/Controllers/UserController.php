<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class UserController extends Controller
{
    public function AuthAdmin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/admin-dashboard');
        }else{
            abort(404);
        }
    }
    public function add_user(){
        $this->AuthAdmin();
        $get_posision = DB::table('tbl_posisions')->get();
        $id_station = DB::table('tbl_post_station')->get();
        return view('admin.pages.adduser', ['get_posision'=>$get_posision, 'id_station' => $id_station]);
    }

    public function user_add_process(Request $request){
        $this->AuthAdmin();
        $data = array();
        $data['staff_name'] = $request->staff_name;
        $data['staff_phone'] = $request->staff_phone;
        $data['Staff_email'] = $request->Staff_email;
        $data['staff_username'] = $request->staff_username;
        $data['staff_password'] = md5($request->staff_phone);
        $data['is_working'] = '1';
        $data['is_station_master'] = '0';
        $data['id_posision'] = $request->id_posision;
        $data['id_station'] = $request->id_station;
        //print_r($data);
        $result = DB::table('staff')->insert($data);
        if($result){
            Session::put('msg_adduser', 'Thêm Thành Công!');
            return Redirect('/add-user');
        }else{
            Session::put('msg_adduser', 'Đã có lỗi xảy ra!');
            return Redirect('/add-user');
        }

    }
}
