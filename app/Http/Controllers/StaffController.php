<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
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
        $status = array();
        $status['id_status'] = '3';
        foreach($result as $row){
            $traking['id_tracking'] = $row;
            
            //print_r($traking).'<br>';
           
            // DB::table('located')->insert($traking);
            // DB::table('tbl_tracking_number')->update($status);
           
            try {
                DB::table('located')->insert($traking);
                DB::table('tbl_tracking_number')->update($status);
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
        
                if ($errorCode == 1062) {
                    
                    $errors[] = 'Dữ liệu đã tồn tại hoặc vi phạm ràng buộc.';
                } else {
                    
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
            ->where('id_status', 3)
            ->where('id_station', Session::get('id_station'))
            ->get();
        return view('staff.alltracking', ['get_all_tracking'=> $get_all_tracking]);
    }

    public function processData(Request $request) {
        $get_province = $request->selectedValue;
        // lấy id_province của trạm mà nhân viên đang công tác
        $get_id_province = DB::table('tbl_post_station')
            ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_post_station.id_district')
            ->where('id_station', Session::get('id_station'))
            ->first();
        //print_r($get_id_province);
        //echo $get_id_province->id_province;
        if($get_province == 'same'){
            //lấy ra các đơn mà có id_province = province_receive
            $result = DB::table('located')
                ->join('staff', 'staff.id_staff', '=', 'located.id_staff')
                ->join('tbl_tracking_number', 'tbl_tracking_number.id_tracking', '=', 'located.id_tracking')
                ->where('id_status', 3)
                ->where('province_receive', '=',$get_id_province->id_province)
                ->where('id_station', Session::get('id_station'))
                ->get();
        }elseif($get_province =='different'){
            //lấy ra các đơn mà có id_province != province_receive
            $result = DB::table('located')
                ->join('staff', 'staff.id_staff', '=', 'located.id_staff')
                ->join('tbl_tracking_number', 'tbl_tracking_number.id_tracking', '=', 'located.id_tracking')
                ->where('id_status', 3)
                ->where('province_receive', '<>', $get_id_province->id_province)
                ->where('id_station', Session::get('id_station'))
                ->get();
        }else{
            //tất cả
            $result = DB::table('located')
                ->join('staff', 'staff.id_staff', '=', 'located.id_staff')
                ->join('tbl_tracking_number', 'tbl_tracking_number.id_tracking', '=', 'located.id_tracking')
                ->where('id_status', 3)
                ->where('id_station', Session::get('id_station'))
                ->get();
        }
        return response()->json($result);
    }

    public function checkInTruck(){
        $this->AuthStaff();
        $check_driver = DB::table('staff')->where('id_staff', Session::get('id_staff'))->where('id_posision', '11')->first();
        if($check_driver){
            $chek_have_truck = DB::table('tbl_truck')
                ->where('id_truck', Session::get('id_staff'))
                ->where('id_staff', '>', 0)
                ->get();
            if($chek_have_truck){
                Session::put('error', null);
                $get_truck_info = DB::table('tbl_truck')
                    ->join('truck_status', 'truck_status.id_truck_status', '=', 'tbl_truck.id_truck_status')
                    ->where('id_staff', Session::get('id_staff'))->first();
                $today = Carbon::now('Asia/Ho_Chi_minh')->format('Y-m-d');
                $get_log_today = DB::table('truck_log')
                    ->join('tbl_truck', 'tbl_truck.id_truck', '=', 'truck_log.id_truck')
                    ->join('truck_status','truck_status.id_truck_status', '=', 'tbl_truck.id_truck_status')
                    ->join('tbl_post_station', 'tbl_post_station.id_station', '=', 'truck_log.id_station')
                    ->where('tbl_truck.id_staff', Session::get('id_staff'))
                    ->where('thoi_gian', $today)
                    ->orderBy('id_trucklog', 'DESC')
                    ->get();

                
                $get_station = DB::table('tbl_post_station')
                    ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_post_station.id_district')
                    ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_district.id_province')
                    ->where('province_name', $get_truck_info->start_point)
                    ->orWhere('province_name', $get_truck_info->end_point)
                    ->get();
                
                $current_station = DB::table('truck_log')
                    ->where('id_staff', Session::get('id_staff'))
                    ->orderBy('id_trucklog', 'DESC')
                    ->first();
                return view('staff.checkintruck', ['get_truck_info'=>$get_truck_info, 'get_log_today'=>$get_log_today, 'get_station'=>$get_station, 'current_station'=>$current_station]);
            }else{
                Session::put('error', 'bạn chưa có xe tải nhe!');
                return view('staff.checkintruck');
            }
        }else{
            return Redirect::to('/staff/')->with('msg_role', 'Bạn Không có quyền truy cập!');
        }
    }
    public function truckLog(Request $request){
        $this->AuthStaff();
        $today = Carbon::now('Asia/Ho_Chi_Minh');
        $process = $request->process;
        $id_truck = $request->id_truck;
        if($process == 'checkin'){
            $data = array();
            $data['truck_status'] = 'Đã nhận';
            $data['id_staff'] = Session::get('id_staff');
            $data['id_station'] = Session::get('id_station');
            $data['id_truck'] = $id_truck;
            $data['note'] = 'Bắt đầu phiên làm việc';
            $data['thoi_gian'] = $today->format('Y-m-d');
            $data['create_at'] = now();
            $insert = DB::table('truck_log')->insert($data);

            $truck = array();
            $truck['id_truck_status']='2';
            $updata_status = DB::table('tbl_truck')->where('id_truck', $request->id_truck)->update($truck);
            if($insert && $updata_status){
                return Redirect::to('/staff/check-in-truck')->with('msg', 'Check In Thành Công!');
            }else{
                return Redirect::to('/staff/check-in-truck')->with('msg', 'Đã có lỗi xảy ra!');
            }
            
            
        }elseif($process == 'roaldout'){
            $data = array();
            $data['truck_status'] = 'Khởi Hành';
            $data['id_staff'] = Session::get('id_staff');
            $data['id_station'] = $request->id_station;
            $data['id_truck'] = $id_truck;
            $data['note'] = 'Khởi hành';
            $data['thoi_gian'] = $today->format('Y-m-d');
            $data['create_at'] = now();
            //print_r($data);
            $insert = DB::table('truck_log')->insert($data);
            $truck = array();
            $truck['id_truck_status']='4';
            $updata_status = DB::table('tbl_truck')->where('id_truck', $request->id_truck)->update($truck);
            if($insert && $updata_status){
                return Redirect::to('/staff/check-in-truck')->with('msg', 'Thao Tác Thành Công!');
            }else{
                return Redirect::to('/staff/check-in-truck')->with('msg', 'Đã có lỗi xảy ra!');
            }
        }elseif($process == 'arrived'){
            $get_station = DB::table('tbl_post_station')->where('id_station', $request->id_station)->first();
            $data = array();
            $data['truck_status'] = 'Đã đến Trạm';
            $data['id_staff'] = Session::get('id_staff');
            $data['id_station'] = $request->id_station;
            $data['id_truck'] = $id_truck;
            $data['note'] = 'Đã đến trạm: '.$get_station->station_name;
            $data['thoi_gian'] = $today->format('Y-m-d');
            $data['create_at'] = now();
            $insert = DB::table('truck_log')->insert($data);
            $truck = array();
            $truck['id_truck_status']='3';
            $updata_status = DB::table('tbl_truck')->where('id_truck', $request->id_truck)->update($truck);
            if($insert && $updata_status){
                return Redirect::to('/staff/check-in-truck')->with('msg', 'Thao Tác Thành Công!');
            }else{
                return Redirect::to('/staff/check-in-truck')->with('msg', 'Đã có lỗi xảy ra!');
            }
        }elseif($process == 'checkout'){
            if($request->id_station == Session::get('id_station')){
                $get_station = DB::table('tbl_post_station')->where('id_station', $request->id_station)->first();
                $data = array();
                $data['truck_status'] = 'Check-out';
                $data['id_staff'] = Session::get('id_staff');
                $data['id_station'] = $request->id_station;
                $data['id_truck'] = $id_truck;
                $data['note'] = 'Kết thúc phiên làm việc';
                $data['thoi_gian'] = $today->format('Y-m-d');
                $data['create_at'] = now();
                $insert = DB::table('truck_log')->insert($data);
                $truck = array();
                $truck['id_truck_status']='1';
                $updata_status = DB::table('tbl_truck')->where('id_truck', $request->id_truck)->update($truck);
                if($insert && $updata_status){
                    return Redirect::to('/staff/check-in-truck')->with('msg', 'Thao Tác Thành Công!');
                }else{
                    return Redirect::to('/staff/check-in-truck')->with('msg', 'Đã có lỗi xảy ra!');
                }
            }else{
                return Redirect::to('/staff/check-in-truck')->with('msg', 'Bạn chưa về trạm khởi đầu!');
            }
        }
        
    }
}

