<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

use APP\Http\Requests;
use Psy\Command\WhereamiCommand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
//use App\Imports\ImportTest;
use App\Imports\ImportTracking;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

session_start();

class homecontroller extends Controller
{

    public function Auth_login(){
        $id_user = Session::get('id_user');
        if(!$id_user){
            return abort(404);
        }
    }

    public function must_login(){
        $id_user = Session::get('id_user');
        if($id_user){
            return true;
        }
    }

    public function index(Request $request) {
        if(isset($request->tracking) && $request->tracking != ''){
            $id_tracking = $request->tracking;
            $tracking_info = DB::table('located')->where('id_tracking', $id_tracking)->get();
            if($tracking_info->isEmpty()){
                return Redirect('/')->with('error', 'Hệ thông không phát hiện đơn hàng: '.$id_tracking);
            }else{
                return view('pages.home', ['tracking'=>$tracking_info, 'info'=>$id_tracking]);
            }
            
        }else{
            return view('pages.home');
        }
        
    }

    public function register(){
        return view('register');
    }

    public function register_process(Request $request){
        
        $request->validate([
            'captcha' => 'required|captcha',
        ]);
        
        // check usn
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
            $data['id_rank'] = 1;
            $data['customer_type'] =$request->customer_type;

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
        $request->validate([
            'captcha'=>'required|captcha',
        ]);
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
            Session::put('customer_type', $result->customer_type);
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
        if($this->must_login() == true){
        $get_profile = DB::table('users')->where('id_user', Session('id_user'))->first();
        $get_address = DB::table('tbl_address')
            ->where('id_user', Session('id_user'))
            ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_address.id_province')
            ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_address.id_district')
            ->get();
        $get_province = DB::table('tbl_province')->get();
        $get_service = DB::table('extra_service')->orderBy('id_extra_service', 'ASC')->get();
        return view('pages.createtracking', 
            [
                'get_province'=>$get_province, 
                'get_service'=>$get_service,
                'get_address'=>$get_address,
                'get_user'=>$get_profile,
            ]
        );
        }else{
            return Redirect('/login');
        }
        
    }

    public function creating_process(Request $request){
        $this->Auth_login();
        if(isset($request->address_sent)){
            $messages = [
                'address_sent.required'=>'Bạn chưa nhập địa chỉ gửi hàng!',
                'province_sent.required'=>'Bạn chưa chọn tỉnh gửi!',
                'district_sent.required'=>'Bạn chưa chọn huyện gửi!',
                'name_sent.required'=>'Bạn chưa điền tên người gửi!',
                'phone_sent.required'=>'Bạn chưa điền số điện thoại!',
                'address_receive.required'=>'Bạn chưa điền địa chỉ người nhận!',
                'province_receive.required'=>'Bạn chưa chọn Tỉnh nhận!',
                'district_receive.required'=>'Bạn chưa chọn Huyện nhận!',
                'name_receive.required'=>'Bạn chưa điền tên người nhận!',
                'phone_receive.required'=>'Bạn chưa điền số điện thoại người nhận!',
                'describe_tracking.required'=>'Bạn chưa điền mô tả đơn hàng!',
                'type_sending.required'=>'Bạn chưa chọn loại ký gửi',
                'width.required'=>'Thiếu chiều dài',
                'height.required'=>'Thiếu chiều rộng',
                'depth.required'=>'Thiếu chiều cao',
                'id_extra_service.required'=>'Chưa chọn loại hàng hóa!',
                'weight.required'=>'Bạn chưa điền trọng lượng',
                'cod.required'=>'Bạn chưa nhập tiền thu hộ !',
            ];
            $request->validate([
                'address_sent'=>'required',
                'province_sent'=>'required',
                'district_sent'=>'required',
                'name_sent'=>'required',
                'phone_sent'=>'required',
                'address_receive'=>'required',
                'province_receive'=>'required',
                'district_receive'=>'required',
                'name_receive'=>'required',
                'phone_receive'=>'required',
                'describe_tracking'=>'required',
                'type_sending'=>'required',
                'width'=>'required',
                'height'=>'required',
                'depth'=>'required',
                'id_extra_service'=>'required',
                'weight'=>'required',
                'cod'=>'required',
            ], $messages);
        }else{
            $messages = [
                'id_address.required'=>'Bạn chưa chọn địa chỉ!',
                'name_sent.required'=>'Bạn chưa điền tên người gửi!',
                'phone_sent.required'=>'Bạn chưa điền số điện thoại!',
                'address_receive.required'=>'Bạn chưa điền địa chỉ người nhận!',
                'province_receive.required'=>'Bạn chưa chọn Tỉnh nhận!',
                'district_receive.required'=>'Bạn chưa chọn Huyện nhận!',
                'name_receive.required'=>'Bạn chưa điền tên người nhận!',
                'phone_receive.required'=>'Bạn chưa điền số điện thoại người nhận!',
                'describe_tracking.required'=>'Bạn chưa điền mô tả đơn hàng!',
                'type_sending.required'=>'Bạn chưa chọn loại ký gửi',
                'width.required'=>'Thiếu chiều dài',
                'height.required'=>'Thiếu chiều rộng',
                'depth.required'=>'Thiếu chiều cao',
                'id_extra_service.required'=>'Chưa chọn loại hàng hóa!',
                'weight.required'=>'Bạn chưa điền trọng lượng',
                'cod.required'=>'Bạn chưa nhập tiền thu hộ !',
            ];
            $request->validate([
                'id_address'=>'required',
                'name_sent'=>'required',
                'phone_sent'=>'required',
                'address_receive'=>'required',
                'province_receive'=>'required',
                'district_receive'=>'required',
                'name_receive'=>'required',
                'phone_receive'=>'required',
                'describe_tracking'=>'required',
                'type_sending'=>'required',
                'width'=>'required',
                'height'=>'required',
                'depth'=>'required',
                'id_extra_service'=>'required',
                'weight'=>'required',
                'cod'=>'required',
            ], $messages);
        }
        //echo  'pass';
        
        $id_address = $request->id_address;
        if(isset($id_address)){
            $get_address = DB::table('tbl_address')
                ->where('id_address', $id_address)
                ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_address.id_province')
                ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_address.id_district')
                ->first();
            $address_sent = $get_address->address_sent;
            $province_sent = $get_address->id_province;
            $district_sent = $get_address->id_district; 
        }else{
            $address_sent = $request->address_sent;
            $province_sent = $request->province_sent;
            $district_sent = $request->district_sent; 
        }

        $data = array();
        $weight=$request->weight;
        $rand_id = time();
        $data['id_tracking'] = 'VN'.$rand_id;
        $data['address_sent'] = $address_sent;
        $data['province_sent'] = $province_sent;
        $data['district_sent'] = $district_sent;
        $data['name_sent'] = $request->name_sent;
        $data['phone_sent'] = $request->phone_sent;
        $data['address_receive'] = $request->address_receive;
        $data['district_receive'] = $request->district_receive;
        $data['province_receive'] = $request->province_receive;
        $data['name_receive'] = $request->name_receive;
        $data['phone_receive'] = $request->phone_receive;
        $data['img_receive'] = '';
        $data['type_sending'] = $request->type_sending;
        $data['describe_tracking'] = $request->describe_tracking;
        $data['demension'] = $request->width.'x'.$request->height.'x'.$request->depth;
        $data['weight'] = $weight;
        $data['cod'] = $request->cod;
        $data['id_status'] = '1';
        $data['id_user'] = Session::get('id_user');
        $data['tracking_created_at'] = now();

        $es = $request->id_extra_service;
        $split_es = explode('-', $es);
        $es_price = $split_es[0];
        $id_extra_service = $split_es[1];
        $data['id_extra_service'] = $id_extra_service; // tách chuỗi ra
        

        if($request->province_receive == $province_sent){
            if($weight <= 500){
                $price_w = 20000;
            }elseif($weight > 500 && $weight <=1000){
                $price_w = 25000;
            }elseif($weight > 1000 && $weight <=3000){
                $price_w = 30000;
            }elseif($weight > 3000){
                $price_w = 30000 + ($weight-3000)*15;
            }
        }else{
            if($weight <= 500){
                $price_w = 25000;
            }elseif($weight > 500 && $weight <=1000){
                $price_w = 30000;
            }elseif($weight > 1000 && $weight <=3000){
                $price_w = 40000;
            }elseif($weight > 3000){
                $price_w = 40000 + ($weight-3000)*15;
            }
        }
        
        //Get Rank
        $get_rank = DB::table('users')
            ->join('tbl_rank', 'tbl_rank.id_rank', '=', 'users.id_rank')
            ->where('id_user', Session('id_user'))
            ->first();
        $disscount_price = $get_rank->rank_disscount;
        
        $tracking_price = $es_price + $price_w;
        $data['tracking_price'] = $tracking_price - $disscount_price; // tính
        print_r($data);
        $result = DB::table('tbl_tracking_number')->insert($data);
        if($result){
            return Redirect::to('/create-tracking')->with('success', 'Thêm Thành Công!');
        }
    }

    public function user(){
        if(Session::get('id_user')){
            $get_rank = DB::table('users')->join('tbl_rank','tbl_rank.id_rank','=','users.id_rank')->where('id_user',Session('id_user'))->first();
            return view('pages.user', ['get_rank'=>$get_rank]);
        }else{
            return abort('404');
        }
    }

    public function list_tracking(Request $request){
        $this->Auth_login();
        $sort = $request->sort;
        if(isset($sort)){
           if($sort == 'created'){
                $data = DB::table('tbl_tracking_number')
                ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
                ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
                ->where('id_user', Session::get('id_user'))
                ->where('id_status', '1')
                ->orderBy('id_tracking','desc')
                ->get();
    
                return view('pages.listtracking', ['data' =>$data]); 

            }elseif($sort == 'process'){
                $data = DB::table('tbl_tracking_number')
                ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
                ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
                ->where('id_user', Session::get('id_user'))
                ->where('id_status', '>', '1')
                ->where('id_status', '<=', '5')
                ->orderBy('id_tracking','desc')
                ->get();
    
                return view('pages.listtracking', ['data' =>$data]); 

            }elseif($sort == 'complete'){
                $data = DB::table('tbl_tracking_number')
                ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
                ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
                ->where('id_user', Session::get('id_user'))
                ->where('id_status', '8')
                ->orderBy('id_tracking','desc')
                ->get();
    
                return view('pages.listtracking', ['data' =>$data]); 

            }elseif($sort == 'fail'){
                $data = DB::table('tbl_tracking_number')
                ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
                ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
                ->where('id_user', Session::get('id_user'))
                ->orderBy('id_tracking','desc')
                ->where('tracking_return', '<>', null)
                ->get();
    
                return view('pages.listtracking', ['data' =>$data]); 

            }else{
                $data = DB::table('tbl_tracking_number')
                ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
                ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
                ->where('id_user', Session::get('id_user'))
                ->orderBy('id_tracking','desc')
                ->get();
    
                return view('pages.listtracking', ['data' =>$data]); 
            }
        }else{
            $data = DB::table('tbl_tracking_number')
                ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
                ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
                ->where('id_user', Session::get('id_user'))
                ->orderBy('id_tracking','desc')
                ->get();
    
            return view('pages.listtracking', ['data' =>$data]); 
        }
        
        
    }

    public function selectProvince(Request $request){
        $province = $request->selectedValue;
        $district = DB::table('tbl_district')->Where('id_province', $province)->get();
        return response()->json($district);
    }

    public function view_tracking($id_tracking){
        $this->Auth_login();
        $get_tracking = DB::table('located')->where('id_tracking', $id_tracking)->get();
        $get_id_tracking = DB::table('tbl_tracking_number')->where('id_tracking',$id_tracking)->first();
        $get_sentaddress = DB::table('tbl_tracking_number')
            ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_sent')
            ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_sent')
            ->where('id_tracking', $id_tracking)
            ->first();
        $get_receiveaddress = DB::table('tbl_tracking_number')
            ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
            ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
            ->where('id_tracking', $id_tracking)
            ->first();
        return view(
            'pages.viewtracking', 
            [
                'get_tracking'=>$get_tracking, 
                'id_tracking'=>$id_tracking, 
                'tracking'=>$get_id_tracking,
                'sender'=>$get_sentaddress, 
                'receive'=>$get_receiveaddress
            ]
        );
    }

    public function barcode(){
        return view('barcode');
    }

    public function generatePDF($id_tracking){
        $this->Auth_login();
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->getDompdf()->setPaper('A5', 'landscape');

        $get_tracking = DB::table('tbl_tracking_number')->where('id_tracking',$id_tracking)->first();
        $get_sentaddress = DB::table('tbl_tracking_number')
            ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_sent')
            ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_sent')
            ->where('id_tracking', $id_tracking)
            ->first();
        $get_receiveaddress = DB::table('tbl_tracking_number')
            ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_tracking_number.district_receive')
            ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_tracking_number.province_receive')
            ->where('id_tracking', $id_tracking)
            ->first();
        $pdf = PDF::loadView('pages.printtracking', ['tracking'=>$get_tracking, 'sender'=>$get_sentaddress, 'receive' =>$get_receiveaddress]);
        return $pdf->stream();
        //return view('pages.printtracking', ['tracking'=>$get_tracking, 'sender'=>$get_sentaddress, 'receive' =>$get_receiveaddress]);
    }

    public function importTracking(){
        $this->Auth_login();
        $get_province = DB::table('tbl_province')->get();
        return view('pages.importtracking', ['get_province'=>$get_province]);
    }

    public function importCsv(Request $request){
        $this->Auth_login();
        $request->validate([
            'address_sent' => 'required',
            'province_sent' => 'required',
            'district_sent' => 'required',
            'name_sent'=> 'required',
            'phone_sent'=> 'required',
            'file'=> 'required'
        ]);
        $path = $request->file('file')->getRealPath();
        $address_sending = [
            'province_sent'=> $request->province_sent,
            'district_sent'=>$request->district_sent,
            'address_sent'=>$request->address_sent,
            'name_sent' => $request->name_sent,
            'phone_sent'=> $request->phone_sent
        ];

        //echo $path;
        try {
            Excel::import(new ImportTracking($address_sending), $path);
            
            // Xử lý thành công, ví dụ: 
            return redirect()->back()->with('success', 'Dữ liệu đã được nhập thành công.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Xử lý lỗi xảy ra trong quá trình xác minh dữ liệu
            $failures = $e->failures(); // Danh sách các lỗi xác minh
    
            foreach ($failures as $failure) {
                $errorRow = $failure->row(); // Dòng chứa lỗi
                $errorMessage = $failure->errors()[0]; // Thông báo lỗi đầu tiên
                // Xử lý lỗi tại đây
            }
    
            return redirect()->back()->with('error', 'Có lỗi xảy ra trong quá trình nhập dữ liệu từ tệp Excel.');
        } catch (\Exception $e) {
            // Xử lý lỗi chung
            return redirect()->back()->with('error', 'Có lỗi xảy ra trong quá trình nhập dữ liệu từ tệp Excel.');
        }
        // Excel::import(new ImportTracking($address_sending), $path);
        //return redirect()->back()->with('success', 'Dữ liệu đã được nhập thành công.');
    }

    public function show_carbon(){
        $this->Auth_login();
        echo Carbon::now('Asia/Ho_Chi_Minh');
    }

    public function userProfile(){
        $this->Auth_login();
        $get_profile = DB::table('users')
            ->join('tbl_rank', 'tbl_rank.id_rank', '=', 'users.id_rank')
            ->where('id_user', Session('id_user'))->first();
        return view('pages.userprofile', ['profile'=> $get_profile]);
    }

    public function changeProfile(Request $request){
        $this->Auth_login();
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'phone' => 'required|min:10|max:10'
        ]);
        $id_user = Session('id_user');
        $lastname = $request->lastname;
        $firstname = $request->firstname;
        $phone = $request->phone;

        $data = [
            'id_user'=>$id_user,
            'lastname'=>$lastname,
            'firstname'=>$firstname,
            'phone'=>$phone,
            'updated_at'=>now()
        ];

        $update = DB::table('users')->where('id_user', $id_user)->update($data);
        if($update){
            return Redirect('/user-profile')->with('success', 'Cập nhật thành công!');
        }else{
            return Redirect('/user-profile')->with('error', 'Đã có lỗi xảy ra!');
        }

    }

    public function myAddress(){
        $this->Auth_login();
        $get_address = DB::table('tbl_address')
            ->where('id_user', Session('id_user'))
            ->join('tbl_province', 'tbl_province.id_province', '=', 'tbl_address.id_province')
            ->join('tbl_district', 'tbl_district.id_district', '=', 'tbl_address.id_district')
            ->get();
        return view('pages.myaddress', ['get_address'=>$get_address]);
    }

    public function addAddress(){
        $this->Auth_login();
        $get_province = DB::table('tbl_province')->get();
        return view('pages.addaddress',['get_province'=>$get_province]);
    }

    public function addAddressProcess(Request $request){
        $this->Auth_login();
        $request->validate([
            'address_sent'=>'required',
            'address_name'=>'required',
            'province_sent'=>'required',
            'district_sent'=>'required'
        ]);

        $address_sent = $request->address_sent;
        $id_province = $request->province_sent;
        $id_district = $request->district_sent;
        $address_name = $request->address_name;
        $data = [
            'address_sent'=>$address_sent,
            'id_province'=>$id_province,
            'id_district'=>$id_district,
            'id_user'=>Session('id_user'),
            'address_name'=>$address_name,
        ];
        $insert = DB::table('tbl_address')->insert($data);
        if($insert){
            return Redirect('/add-address')->with('success', 'Thêm địa chỉ thành công!');
        }else{
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function modifyAddress($id_address){
        $this->Auth_login();
        $get_address = DB::table('tbl_address')->where('id_user', Session('id_user'))->first();
        $get_province = DB::table('tbl_province')->get();
        return view('pages.modifyaddress', ['get_address'=>$get_address, 'get_province'=>$get_province]);
    }

    public function deleteAddress($id_address){
        $this->Auth_login();
        $del = DB::table('tbl_address')->where('id_address', $id_address)->delete();
        if($del){
            return Redirect('/my-address')->with('success', 'Xóa Thành Công!');
        }else{
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function ModifyAddressProcess(Request $request, $id_address){
        $this->Auth_login();
        $request->validate([
            'address_sent'=>'required',
            'address_name'=>'required',
            'province_sent'=>'required',
            'district_sent'=>'required'
        ]);

        $address_sent = $request->address_sent;
        $id_province = $request->province_sent;
        $id_district = $request->district_sent;
        $address_name = $request->address_name;
        $data = [
            'address_sent'=>$address_sent,
            'id_province'=>$id_province,
            'id_district'=>$id_district,
            'id_user'=>Session('id_user'),
            'address_name'=>$address_name,
        ];

        $Update = DB::table('tbl_address')->where('id_address', $id_address)->update($data);
        if($Update){
            return Redirect('/my-address')->with('success', 'Chỉnh sửa thành công!');
        }else{
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function testError(){
        $get_province = DB::table('tbl_province')->get();
        return view('testerror', ['get_province'=>$get_province]);
    }

    public function VNpayPaid(Request $request, $id_tracking){
        $get_tracking = DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->first();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */
          
        $vnp_TmnCode = "1YRH2OT4"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "CURDMARFJLFZEXSEHJPOLMQHNVPCCGDG"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/thynx/payment-info";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        $vnp_TxnRef = $id_tracking; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $id_tracking;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $get_tracking->tracking_price * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        
        $vnp_ExpireDate = $expire;
    
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$vnp_ExpireDate,
    
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            // vui lòng tham khảo thêm tại code demo
    }
    
    public function paymentInfo(Request $request){
        if(isset($request->vnp_ResponseCode) && $request->vnp_ResponseCode == '00'){
            $dateString = $request->vnp_PayDate;
            $timestamp = strtotime($dateString);
            $sqlTimestamp = date('Y-m-d H:i:s', $timestamp);
            $data = [
                'id_tracking' => $request->vnp_TxnRef,
                'vnp_Amount'=>$request->vnp_Amount/100,
                'vnp_BankTranNo'=>$request->vnp_BankTranNo,
                'vnp_OrderInfo'=>$request->vnp_OrderInfo,
                'vnp_PayDate'=>$sqlTimestamp,
                'vnp_TransactionNo'=>$request->vnp_TransactionNo,
            ];
            $check_storage = DB::table('payment_info')->where('vnp_BankTranNo', $request->vnp_BankTranNo)->first();
            if(!$check_storage){
                $storge_payment_info = DB::table('payment_info')->insert($data);
                
            }
            $get_info = DB::table('payment_info')->where('vnp_BankTranNo', $request->vnp_BankTranNo)->first();
            return view('pages.paymentinfo', ['get_info'=>$get_info])->with('success', 'Thanh toán thành công!');
        }else{
            return view('pages.paymentinfo')->with('error', 'Đã có lỗi trong quá trình thanh toán, Bạn vui lòng thử lại sau!');
        }
    }
}
