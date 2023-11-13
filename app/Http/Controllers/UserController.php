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
use PhpOffice\PhpSpreadsheet\Calculation\Database\DVar;

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
        $request->validate([
            'username'=>'required',
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'station'=>'required',
            'posision'=>'required',
        ],
        [
            'username.required'=>'Vui lòng nhập Tài Khoản!',
            'name.required'=>'Vui Lòng nhập Tên!',
            'phone.required'=>'Vui lòng nhập SDT',
            'email.required'=>'Vui lòng nhập thư điện tử!',
            'station.required'=>'Vui lòng chọn trạm',
            'posision.required'=>'Vui lòng chọn chức vụ',
        ]
        );
        $result = DB::table('staff')->insert([
            'staff_name'=> $request->name,
            'staff_phone'=> $request->phone,
            'Staff_email'=> $request->email,
            'staff_username'=> $request->username,
            'staff_password'=> md5($request->phone),
            'is_working'=> '1',
            'is_station_master'=> '0',
            'id_posision'=> $request->posision,
            'id_station'=> $request->station,
        ]);
        if($result){
            return Redirect('/add-user')->with('success', 'Thêm Thành Công!');
        }else{
            return Redirect('/add-user')->with('error', 'Đã có lỗi xảy ra!');
        }

    }

    public function usersList(){
        $this->AuthAdmin();
        $get_staffs = DB::table('staff')
        ->join('tbl_posisions as a','a.id_posision','=','staff.id_posision')
        ->join('tbl_post_station as b','b.id_station','=','staff.id_station')
        ->orderBy('id_staff','ASC')
        ->get();
        return view('admin.pages.userlist', ['staffs'=>$get_staffs]);
    }

    public function editUser($id_staff){
        $this->AuthAdmin();
        $get_staff = DB::table('staff')->where('id_staff', $id_staff)->first();
        $get_station = DB::table('tbl_post_station')->get();
        $get_posision = DB::table('tbl_posisions')->get();
        return view('admin.pages.edituser', ['staff'=>$get_staff, 'get_station'=>$get_station, 'get_posision'=>$get_posision]);
    }

    public function editUserProcess(Request $request, $id_staff){
        $this->AuthAdmin();
        $request->validate([
            'username'=>'required',
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'station'=>'required',
            'posision'=>'required',
        ],
        [
            'username.required'=>'Vui lòng nhập Tài Khoản!',
            'name.required'=>'Vui Lòng nhập Tên!',
            'phone.required'=>'Vui lòng nhập SDT',
            'email.required'=>'Vui lòng nhập thư điện tử!',
            'station.required'=>'Vui lòng chọn trạm',
            'posision.required'=>'Vui lòng chọn chức vụ',
        ]
        );
        $update = DB::table('staff')->where('id_staff', $id_staff)->update([
            'staff_username'=>$request->username,
            'Staff_name'=>$request->name,
            'Staff_phone'=>$request->phone,
            'Staff_email'=>$request->email,
            'id_station'=>$request->station,
            'id_posision'=>$request->posision,
        ]);
        if($update){
            return redirect('/users-list')->with('success','Hiệu chỉnh thành công!');
        }else{
            return redirect('/users-list')->with('error','Đã có lỗi xảy ra!');
        }
    }

    public function deleteUser($id_staff){
        $this->AuthAdmin();
        $delele = DB::table('staff')->where('id_staff', $id_staff)->delete();
        if($delele){
            return redirect('/users-list')->with('success','Xóa thành công!');
        }else{
            return redirect('/users-list')->with('error','Đã có lỗi xảy ra!');
        }
    }
}
