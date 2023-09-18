<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use APP\Http\Requests;
use Psy\Command\WhereamiCommand;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;

session_start();

class homecontroller extends Controller
{

    public function Auth_login(){
        $id_user = Session::get('id_user');
        if($id_user){
            return Redirect::to('/user');
        }else{
            return abort(404);
        }
    }

    public function index() {
        return view('pages.home');
    }

    public function register(){
        return view('register');
    }

    public function register_process(Request $request){
        //check usn
        $check_usn = DB::table('users')->where('username', $request->username)->first();
        if($check_usn){
            Session::put('usn_check', 'Tài khoản đã tồn tại!');
            return Redirect::to('register')->withInput($request->only('firstname', 'lastname', 'email', 'phone'));
        }else{
            // insert BD
            $data = array();
            $data['username'] = $request->username;
            $data['password'] = md5($request->password);
            $data['firstname'] = $request->firstname;
            $data['lastname'] = $request->lastname;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;

            $insert = DB::table('users')->insert($data);
            if($insert){
                Session::put('login_msg', 'Bạn đã đăng ký thành công!');
                return Redirect::to('login');
            }else{
                return Redirect::to('/register');
                    
            }
        }

    }

    public function login(){
        return view('login');
    }

    public function login_process(Request $request){
        $username = $request->username;
        $password = md5($request->password);
        $result = DB::table('users')->where('username', $username)->where('password', $password)->first();
        //print_r($result);
        //echo '<br>';
        //echo $result->email;
        if($result){
            Session::put('login_complete', 'Đăng nhập thành công!');
            Session::put('id_user', $result->id_user);
            Session::put('firstname', $result->firstname);
            return Redirect::to('/user');
        }else{
            Session::put('login_fail', 'Tài Khoản hoặc mật khẩu không đúng');
            return Redirect::to('/login')
                ->withInput($request->only('username'));
        }
    }

    public function logout(){
        Session::put('id_user', null);
        Session::put('firstname', null);
        return Redirect::to('/');
    }

    public function create_tracking(){
        $this->Auth_login();
        $get_province = DB::table('tbl_province')->get();
        return view('pages.createtracking', ['get_province'=>$get_province]);
        
    }

    public function creating_process(Request $request){
        $this->Auth_login();
        $data = array();
        $rand_id = time();
        $data['id_tracking'] = 'VN'.$rand_id;
        $data['address_sent'] = $request->address_sent;
        $data['province_sent'] = $request->province_sent;
        $data['district_sent'] = $request->district_sent;
        $data['name_sent'] = $request->name_sent;
        $data['phone_sent'] = $request->phone_sent;
        $data['address_receive'] = $request->address_receive;
        $data['district_receive'] = $request->district_receive;
        $data['province_receive'] = $request->province_receive;
        $data['name_receive'] = $request->name_receive;
        $data['phone_receive'] = $request->phone_receive;
        $data['img_receive'] = '';
        $data['type_sending'] = $request->type_sending;
        $data['demension'] = $request->demension;
        $data['weight'] = $request->weight;
        $data['id_status'] = '1';
        $data['id_user'] = Session::get('id_user');
        $result = DB::table('tbl_tracking_number')->insert($data);
        if($result){
            Session::put('msg_create_tracking', 'Thêm Thành Công!');
            return Redirect::to('/create-tracking');
        }

    }

    public function user(){
        if(Session::get('id_user')){
            return view('pages.user');
        }else{
            return abort('404');
        }
    }

    public function list_tracking(){
        $this->Auth_login();
        $data = DB::table('tbl_tracking_number')
            ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
            ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
            ->orderBy('id_tracking','desc')
            ->get();
        //print_r($data);
        return view('pages.listtracking', ['data' =>$data]); 
    }

    public function selectProvince(Request $request){
        $province = $request->selectedValue;
        $district = DB::table('tbl_district')->Where('id_province', $province)->get();
        return response()->json($district);
    }

    public function view_tracking($id_tracking){
        $this->Auth_login();
        $get_tracking = DB::table('located')->where('id_tracking', $id_tracking)->get();
        return view('pages.viewtracking', ['get_tracking'=>$get_tracking, 'id_tracking'=>$id_tracking]);
    }

    public function barcode(){
        return view('barcode');
    }

    public function show_carbon(){
        echo Carbon::now('Asia/Ho_Chi_Minh');
    }
}
