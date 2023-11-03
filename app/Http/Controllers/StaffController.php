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

    public function DeliveryReport(){
        $check = DB::table('delivery_report')
            ->where('id_staff', Session('id_staff'))
            ->where('report_date', Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m-d'))
            ->get();
        if($check->isEmpty()){
            try{
                $create = DB::table('delivery_report')->insert([
                    'id_staff'=>Session('id_staff'),
                    'report_date'=> Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m-d'),
                    'total_tracking'=>0,
                    'total_amount'=>0,
                    'complete'=>0,
                ]);
            }catch(QueryException $e){
                abort(500,'Server Error!');
            }
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
        return view('staff.login');
    }

    public function logout(){
        $this->AuthStaff();
        Session::put('id_staff', null);
        Session::put('staff_name', null);
        Session::put('id_station', null);
        Session::put('role', null);
        Session::put('sorting_center', null);
        return Redirect::to('/staff/login');
    }
    
    public function login_process(Request $request){
        $request->validate([
            'captcha' => 'required|captcha',
        ]);
        $staff_username = $request->staff_username;
        $staff_password = md5($request->staff_password);
        $result = DB::table('staff')
            ->join('tbl_post_station','tbl_post_station.id_station','=','staff.id_station')
            ->where('staff_username', $staff_username)
            ->where('staff_password', $staff_password)
            ->first();

        if($result){
            Session::put('id_staff', $result->id_staff);
            Session::put('staff_name', $result->staff_name);
            Session::put('id_station', $result->id_station);
            Session::put('role', $result->id_posision);
            if($result->is_SC == 1) Session::put('sorting_center', 1);
            Session::put('msg_staff_login', 'Đăng nhập Thành Công');

            return Redirect::to('/staff/dashboard');
        }else{
            return Redirect::to('/staff/login')->with('staff_login_error', 'Tài Khoản hoặc mật khẩu không đúng!');
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
        $traking['LC_status'] = '3';
        $traking['created_at'] = now();
        $traking['updated_at'] = now();
        $data= $request->input1;
        $result = explode(",", $data);
        $status['id_status'] = '3';
        DB::beginTransaction();    
        //print_r($traking).'<br>';
        //print_r($result);  
        // DB::table('located')->insert($traking);
        // DB::table('tbl_tracking_number')->update($status);   
    
        try {
            foreach($result as $row){
                if($row == '') continue;
                $traking['id_tracking'] = $row;
                //($traking).'<br>';
                DB::table('located')->insert($traking);
                DB::table('tbl_tracking_number')->where('id_tracking', $row)->update($status);
            }
            DB::commit();
            return Redirect::to('/staff/confirm-arrived')->with('msg', 'Thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::to('/staff/confirm-arrived')->with('error', 'Đã có lỗi xảy ra!');
        }
    }

    public function all_tracking(){
        $this->AuthStaff();
        $get_all_tracking = DB::table('located')
            ->join('staff', 'staff.id_staff', '=', 'located.id_staff')
            ->join('tbl_tracking_number', 'tbl_tracking_number.id_tracking', '=', 'located.id_tracking')
            ->where('id_status', 3)
            ->where('id_station', Session::get('id_station'))
            ->where('LC_status', 3)
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
                    ->orderBy('id_trucklog', 'ASC')
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

                $get_bag_in_truck = DB::table('tbl_bag')
                    ->join('tbl_truck', 'tbl_truck.id_truck', '=', 'tbl_bag.id_truck')
                    ->join('tbl_post_station', 'tbl_post_station.id_station', '=', 'tbl_bag.id_station')
                    ->where('tbl_bag.id_truck', $get_truck_info->id_truck)
                    ->get();
                return view(
                    'staff.checkintruck', 
                    [
                        'get_truck_info'=>$get_truck_info, 
                        'get_log_today'=>$get_log_today, 
                        'get_station'=>$get_station, 
                        'current_station'=>$current_station,
                        'truck_bag'=>$get_bag_in_truck,
                    ]
                );
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
        }elseif($process == 'bagout'){
            $id_truck = $request->id_truck;
            $id_bag = $request->id_bag;

            $data=[
                'id_truck'=>null,
                'bag_status'=>-1
            ];
            // update id_truck của bag đó thành null, bag_status = -1
            $update = DB::table('tbl_bag')->where('id_bag', $id_bag)->update($data);
            if($update){
                return Redirect::to('/staff/check-in-truck')->with('msg','Thành công!');
            }
        }
        
    }

    public function getTracking(){
        $this->AuthStaff();
        $this->DeliveryReport();
        //them thongkedon ngay hom nay
        //echo Session('id_staff');
        echo $today = Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $get_today_thongke = DB::table('thongkedon')->where('id_staff', Session('id_staff'))->where('ngay_thongke', $today)->first();
        print_r($get_today_thongke);
        if(!$get_today_thongke){
            $today_thongke = [
                'ngay_thongke'=>$today,
                'id_staff'=>Session('id_staff'),
                'so_don'=>0,
            ];
            DB::table('thongkedon')->insert($today_thongke);  
        }

        //lay thong tin don hang
        $tomorrow = Carbon::tomorrow('Asia/Ho_Chi_Minh');
        
        $station = DB::table('tbl_post_station')->where('id_station', Session::get('id_station'))->first();
        $get_tracking_on_station = DB::table('tbl_tracking_number')
            ->where('district_sent', $station->id_district)
            ->where('id_status', '=', 1)
            ->orWhere('id_status', '=', 7)
            ->where('tracking_updated_at', '>', $tomorrow)
            ->get();
       
        return view('staff.gettracking', [
            'tracking'=>$get_tracking_on_station,
            
        ]);
    }

    public function receiveTracking(){
        $this->AuthStaff();
        $this->DeliveryReport();
        $station = DB::table('tbl_post_station')->where('id_station', Session::get('id_station'))->first();
        $get_tracking_to_deliver = DB::table('tbl_tracking_number')
        ->where('id_status', 3)
        ->where('district_receive', $station->id_district)
        ->get();
        return view('staff.receivetracking',['deliver'=>$get_tracking_to_deliver]);
    }

    public function getTrackingProcess($id_tracking, Request $request){
        $this->AuthStaff();
        if($request->get == 'success'){
           //thêm vào located
            $data = array();
            $data['note'] = 'Lấy thành công';
            $data['id_tracking'] = $id_tracking;
            $data['LC_status'] = 2;
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $data['id_staff'] = Session::get('id_staff');
            $insert = DB::table('located')->insert($data);
            //Update trạng thái đơn hàng = 2 (lấy thành công)
            $tracking = array();
            $tracking['id_status'] = 2;
            $tracking['tracking_updated_at'] = now();
            $update = DB::table('tbl_tracking_number')
                ->where('id_tracking', $id_tracking)
                ->update($tracking);

            if($insert && $update){
                return Redirect::to('/staff/get-tracking')->with('success', "Thao Tác Thành Công!");
            }
        }elseif($request->get == 'fail'){
            //thêm vào located
            $data = array();
            $data['note'] = 'Lấy không thành công!';
            $data['id_tracking'] = $id_tracking;
            $data['LC_Status'] = 7;
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $data['id_staff'] = Session::get('id_staff');
            $insert = DB::table('located')->insert($data);
            //Update trạng thái đơn hàng = 7 (lấy không thành công)
            $tracking = array();
            $tracking['id_status'] = 7;
            $tracking['tracking_updated_at'] = now();
            $update = DB::table('tbl_tracking_number')
                ->where('id_tracking', $id_tracking)
                ->update($tracking);

            if($insert && $update){
                return Redirect::to('/staff/get-tracking')->with('success', "Thao Tác Thành Công!");
            }
        }elseif($request->get == 'todeliver'){
            //thêm vào located
            $data = array();
            $data['note'] = 'Đang giao hàng!';
            $data['id_tracking'] = $id_tracking;
            $data['LC_status'] = 5;
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $data['id_staff'] = Session::get('id_staff');
            $insert = DB::table('located')->insert($data);
            //Update trạng thái đơn hàng = 5 (đang giao hàng)
            $tracking = array();
            $tracking['id_status'] = 5;
            $tracking['tracking_updated_at'] = now();
            $update = DB::table('tbl_tracking_number')
                ->where('id_tracking', $id_tracking)
                ->update($tracking);

            if($insert && $update){
                return Redirect::to('/staff/get-tracking')->with('success', "Thao Tác Thành Công!");
            }
        }
    }

    public function deliverTracking(){
        $this->DeliveryReport();
        $today = Carbon::today('Asia/Ho_Chi_Minh');
        $tracking = DB::table('tbl_tracking_number')
            ->join('located', 'located.id_tracking', '=', 'tbl_tracking_number.id_tracking')
            ->where('id_status', 5)
            ->where('id_staff', Session::get('id_staff'))
            ->where('created_at', '>', $today)
            ->get();
        return view('staff.delivertracking', ['tracking'=>$tracking]);
    }

    public function deliverComplete(Request $request, $id_tracking){
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Kiểm tra phần mở rộng và loại MIME của tệp
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $imageSize = $image->getSize();

            if (
                in_array(strtolower($image->getClientOriginalExtension()), $allowedExtensions) &&
                in_array($image->getClientMimeType(), $allowedMimeTypes) &&
                getimagesize($image) &&
                $imageSize <= 5*1024*1024
            ) {
                //echo 'thành công';
                // lưu tệp vào cloudinary
                $cloudinaryUpload = Cloudinary::upload($image->getRealPath(), ['public_id' => $id_tracking]);
                $imageUrl = $cloudinaryUpload->getSecurePath();
                $publicId = $cloudinaryUpload->getPublicId();
                //echo $publicId;

                // lưu CSDL
                if($imageUrl){
                    //lấy thông tin đơn hôm nay
                    $today = Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m-d');
                    $get_report = DB::table('delivery_report')->where('report_date', $today)->where('id_staff', Session('id_staff'))->first();
                    //lấy thông tin tiền thu hộ của đơn hàng
                    $get_tracking = DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->first();
                    //Cap nhat so don moi
                    $total_tracking = $get_report->total_tracking + 1;
                    $total_amount = $get_report->total_amount + $get_tracking->cod;
                    $data_total_tracking = [
                        'total_tracking'=>$total_tracking,
                        'total_amount'=> $total_amount,
                    ];
                    $update_total_tracking = DB::table('delivery_report')->where('id_report', $get_report->id_report)->update($data_total_tracking);

                    //Cap nhat trang thai don hang
                    $data = array();
                    $data['img_receive'] = $imageUrl;
                    $data['id_status'] = 8;
                    $update = DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->update($data);

                    //chèn csdl located
                    $tracking =array();
                    $tracking['note'] = 'Giao thành công';
                    $tracking['id_staff'] = Session::get('id_staff');
                    $tracking['id_tracking'] = $id_tracking;
                    $tracking['LC_status'] = 8;
                    $tracking['created_at'] = now();
                    $tracking['updated_at'] = now();
                    $insert = DB::table('located')->insert($tracking);
                    // nếu update và insert thì trả về ngược lại thì hủy upload
                    if($insert && $update && $update_total_tracking){
                        return Redirect::to('/staff/deliver-tracking')->with('success', 'Thao tác thành công!');
                    }else{
                        Cloudinary::destroy($publicId);
                        return Redirect::to('/staff/deliver-tracking')->with('error', 'Lỗi lưu trữ!');
                    }
                    
                }else{
                    return Redirect::to('/staff/deliver-tracking')->with('error', 'Lỗi upload ảnh!');
                }
            }else{
                return Redirect::to('/staff/deliver-tracking')->with('error', 'Ảnh không hợp lệ!');
            }
        }    
    }


    public function deliverFail(Request $request, $id_tracking){
        $this->AuthStaff();
        $data = array();
        $data['id_status'] = 3;
        $update = DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->update($data);

        $tracking =array();
        $tracking['note'] = $request->lydo;
        $tracking['id_staff'] = Session::get('id_staff');
        $tracking['id_tracking'] = $id_tracking;
        $tracking['LC_status'] = 6; 
        $tracking['created_at'] = now();
        $tracking['updated_at'] = now();
        $insert = DB::table('located')->insert($tracking);

        $tracking_after =array();
        $tracking_after['note'] = 'trả về bưu cục';
        $tracking_after['id_staff'] = Session::get('id_staff');
        $tracking_after['id_tracking'] = $id_tracking;
        $tracking_after['LC_status'] = 9; 
        $tracking_after['created_at'] = now();
        $tracking_after['updated_at'] = now();
        $insert = DB::table('located')->insert($tracking_after);
        if($insert && $update && $tracking_after){
            return Redirect::to('/staff/deliver-tracking')->with('success', 'thao tác thành công!');
        }
    }

    public function addToBag(){
        $this->AuthStaff();
        $today = Carbon::today()->format('Y-m-d');
        //echo $today;
        //$id_tracking = $request->id_tracking;
        $id_station = Session::get('id_station');

        //xem CSDL bảng BAG đã có ngày hôm nay chưa có thì thôi chưa thì tạo
        $check_bag_to_PL = DB::table('tbl_bag')
            ->where('date', $today)
            ->where('id_station', $id_station)
            ->where('goto', 'PL') // sẽ chỉnh sửa sau
            ->first();
        if(empty($check_bag_to_PL)){
            $new_bag = [
                'bag_name'=>'bao hàng hóa đi trạm phân loại '.$today,
                'id_station'=>$id_station,
                'goto'=>'PL',
                'date'=>$today,
                'bag_status'=>1,
            ];
            //print_r($new_bag);
            $create_bag = DB::table('tbl_bag')->insert($new_bag);
        }

        $check_bag_own_province = DB::table('tbl_bag')
            ->where('date', $today)
            ->where('id_station', $id_station)
            ->where('goto', 'OWN')
            ->first();
       
        if(empty($check_bag_own_province)){
            $new_bag2 = [
                'bag_name'=>'bao hàng hóa đi trong tỉnh '.$today,
                'id_station'=>$id_station,
                'goto'=>'OWN',
                'date'=>$today,
                'bag_status'=>1,
            ];
            //print_r($new_bag2);
            $create_bag2 = DB::table('tbl_bag')->insert($new_bag2);
        }
        return view('staff.addtobag');
    }

    public function processAddBag(Request $request){
       
        $this->AuthStaff();
        $today = Carbon::today()->format('Y-m-d');
        //echo $today;
        //$id_tracking = $request->id_tracking;
        $id_station = Session::get('id_station');

        // UPDATE TRACKING có id_bag dựa theo tuyến đi
        $array_tracking = $request->id_tracking;
        $trackings = explode(",", $array_tracking);
        DB::beginTransaction();
        try {
            foreach($trackings as $id_tracking){
                if($id_tracking == '') continue;
                $tracking = DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->first();
                $station = DB::table('tbl_post_station')
                    ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_post_station.id_district')
                    ->where('id_station', $id_station)
                    ->first();
                $province_receive =  $tracking->province_receive;
                if($station->id_province != $province_receive){
                    $located = [
                        'note'=>'Đang vận chuyển đến TT Phân Loại',
                        'LC_status'=>4,
                        'id_tracking'=>$id_tracking,
                        'id_staff'=>Session('id_staff'),
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ];
                    $insert_lc = DB::table('located')->insert($located);
                    //đi trung tâm phân loại - UPDATE id_bag của của tracking thành id_bag của ngày hôm đó
                    $get_bag_1 = DB::table('tbl_bag')
                        ->where('date', $today)
                        ->where('id_station', $id_station)
                        ->where('goto', 'PL') // sẽ chỉnh sửa sau
                        ->first();
                    $update_tracking = [
                        'id_bag' => $get_bag_1->id_bag
                    ];
                    print_r($update_tracking);
                    DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->update($update_tracking);
                    
                }else{
                    $located = [
                        'note'=>'Đang vận chuyển đến Trạm Giao',
                        'LC_status'=>4,
                        'id_tracking'=>$id_tracking,
                        'id_staff'=>Session('id_staff'),
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ];
                    $insert_lc = DB::table('located')->insert($located);
                    //echo 'đi trong tỉnh';
                    $get_bag_2 = DB::table('tbl_bag')
                        ->where('date', $today)
                        ->where('id_station', $id_station)
                        ->where('goto', 'OWN') // sẽ chỉnh sửa sau
                        ->first();
                    $update_tracking = [
                        'id_bag' => $get_bag_2->id_bag
                    ];
                    print_r($update_tracking);
                    DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->update($update_tracking);     
                }
            }
            DB::commit();
            return Redirect::to('/staff/add-to-bag')->with('success', 'thành công!');
        }catch(\Exception $e){
            DB::rollback();
            return Redirect::to('/staff/add-to-bag')->with('error', 'Đã có lỗi xảy ra!');
        }
        
        
    }

    public function toTruck(){
        $this->AuthStaff();
        $id_station = Session('id_station');
        $today = Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $get_bag = DB::table('tbl_bag')
            ->where('date', '>=' ,$today)
            ->where('bag_status', '>=', '0')
            ->where('id_station', Session('id_station'))
            ->get();
        $select_truck = DB::table('truck_log')
            ->join('tbl_truck', 'tbl_truck.id_truck', '=', 'truck_log.id_truck')
            ->where('truck_status', 'Đã đến Trạm')
            ->where('thoi_gian', $today)
            ->where('id_station', $id_station)
            ->get();
        return view('staff.totruck', ['bag'=>$get_bag, 'select_truck'=>$select_truck]);
    }

    public function toTruckprocess(Request $request, $id_bag){
        $id_truck = $request->id_truck;
        $update = [
            'id_truck'=>$id_truck,
            'bag_status'=>'0',
        ];

        $to_truck = DB::table('tbl_bag')->where('id_bag', $id_bag)->update($update);
        if($to_truck){
            return Redirect::to('/staff/to-truck')->with('success', 'Thành công!');
        }else{
            return Redirect::to('/staff/to-truck')->with('error', 'Đã có lỗi xảy ra');
        }
    }

    public function viewBag($id_bag){
        $get_tracking_in_bag = DB::table('tbl_tracking_number')
            //->join('tbl_province', 'tbl_province.id_province','=', 'tbl_tracking_number.province_sent')
            ->join('tbl_province','tbl_province.id_province','=', 'tbl_tracking_number.province_receive')
            ->where('id_bag', $id_bag)
            ->get();
        $get_bag = DB::table('tbl_bag')->where('id_bag', $id_bag)->first();
        return view('staff.viewbag', ['tracking'=>$get_tracking_in_bag, 'bag'=>$get_bag]);
    }

    public function myTruck(){
        $get_truck = DB::table('tbl_truck')->where('id_staff', Session('id_staff'))->first();
        $get_bag_on_truck = DB::table('tbl_bag')
            ->join('tbl_post_station','tbl_post_station.id_station','=','tbl_bag.id_station')
            ->where('id_truck', $get_truck->id_truck)
            ->where('bag_status', 1)
            ->get();
        //echo $get_truck->id_truck;
        return view('staff.mytruck', ['get_truck'=>$get_truck, 'list_bag'=>$get_bag_on_truck]);
    }

    public function Bag($id_bag){
        $select_tracking = DB::table('tbl_tracking_number')->where('id_bag',$id_bag)->get();
        print_r($select_tracking);
    }
}

