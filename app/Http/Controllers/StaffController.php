<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class StaffController extends Controller
{
    public function AuthStaff(){
        $id_staff = Session::get('id_staff');
        if($id_staff){
            return Redirect::to('/staff/');
        }else{
            abort(404);
        }
    }
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
        $this->AuthStaff();
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
            Session::put('id_station', $result->id_station);
            Session::put('msg_staff_login', 'Đăng nhập Thành Công');

            return Redirect::to('/staff/dashboard');
        }else{
            Session::put('staff_login_error', 'Tài Khoản hoặc mật khẩu không đúng!');
            return Redirect::to('/staff/login');
        }
    }

    public function staff_profile(){
        $this->AuthStaff();
        $get_staff_info = DB::table('staff')->where('id_staff', Session::get('id_staff'))->first();
        return view('staff.profile', ['staff_info'=>$get_staff_info]);
    }

    public function user_change(Request $request){
        $this->AuthStaff();
        $data = array();
        $data['staff_name'] = $request->staff_name;
        $data['staff_phone'] = $request->staff_phone;
        $data['Staff_email'] = $request->Staff_email;
        
        $result = DB::table('staff')->where('id_staff', Session::get('id_staff'))->update($data);
        if($result){
            Session::put('msg_update_info', 'Cập nhật thành công!');
            return Redirect::to('/staff/profile');
        }else{
            Session::put('msg_update_info', 'đã có lỗi xảy ra!');
            return Redirect::to('/staff/profile');
        }
    }

    public function setting(){
        $this->AuthStaff();
        $get_info = DB::table('staff')
            ->join('tbl_posisions', 'staff.id_posision', '=', 'tbl_posisions.id_posision')
            ->where('id_staff', Session::get('id_staff'))
            ->get();
        

        return view('staff.setting', ['info' => $get_info]);
    }

    public function change_password(Request $request){
        $this->AuthStaff();
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

    public function confirm_arrived(){
        $this->AuthStaff();
        return view('staff.confirmarrived');
    }

    public function arrived_process(Request $request){
        $this->AuthStaff();
        $get_station = DB::table('tbl_post_station')->where('id_station', Session::get('id_station'))->first();
        $traking = array();
        $traking['id_staff'] = Session::get('id_staff');
        $traking['note'] = 'Đã đến trạm: '.$get_station->station_name;
        $traking['created_at'] = now();
        $traking['updated_at'] = now();
        $data= $request->input1;
        $result = explode(",", $data);
        $errors = [];
        foreach($result as $row){
            $traking['id_tracking'] = $row;
            $traking['id_status'] = 2;
            
            
            //print_r($traking).'<br>';
           
            //DB::table('located')->insert($traking);
           
            try {
                DB::table('located')->insert($traking);
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
        
                if ($errorCode == 1062) {
                    // Xử lý lỗi duy nhất hoá (unique constraint) hoặc lỗi khóa ngoại (foreign key constraint)
                    // Thí dụ: thêm thông báo lỗi vào mảng lưu trữ
                    $errors[] = 'Dữ liệu đã tồn tại hoặc vi phạm ràng buộc.';
                } else {
                    // Xử lý các lỗi khác
                    // Thí dụ: thêm thông báo lỗi vào mảng lưu trữ
                    $errors[] = 'Đã xảy ra lỗi khi thêm dữ liệu.';
                }
            }
        }
        if (count($errors) > 0) {
            return redirect()->back()->withErrors(['messages' => $errors]);
        }
        return Redirect::to('/staff/confirm-arrived')->with('msg', 'Thành công');
    }

    public function all_tracking(){
        $this->AuthStaff();
        $get_all_tracking = DB::table('located')
            ->join('staff', 'staff.id_staff', '=', 'located.id_staff')
            ->join('tbl_tracking_number', 'tbl_tracking_number.id_tracking', '=', 'located.id_tracking')
            ->where('id_status', 2)
            ->where('id_station', Session::get('id_station'))
            ->paginate(10);
        return view('staff.alltracking', ['get_all_tracking'=> $get_all_tracking]);
    }

    public function processData($selectvalue) {
        
    }
}

