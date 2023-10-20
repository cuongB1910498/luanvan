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
        if($id_user){
            return Redirect::to('/user');
        }else{
            return abort(404);
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
            ]
        );
        
    }

    public function creating_process(Request $request){
        $this->Auth_login();
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
        
        $tracking_price = $es_price + $price_w;
        $data['tracking_price'] = $tracking_price; // tính
        print_r($data);
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
        $get_province = DB::table('tbl_province')->get();
        return view('pages.importtracking', ['get_province'=>$get_province]);
    }

    public function importCsv(Request $request){
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
        echo Carbon::now('Asia/Ho_Chi_Minh');
    }

    public function userProfile(){
        $get_profile = DB::table('users')->where('id_user', Session('id_user'))->first();
        return view('pages.userprofile', ['profile'=> $get_profile]);
    }

    public function changeProfile(Request $request){
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
}
