<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use APP\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class homecontroller extends Controller
{
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
            return Redirect::to('register');
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
                return Redirect::to('register');
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
            return Redirect::to('/');
        }else{
            Session::put('login_fail', 'Tài Khoản hoặc mật khẩu không đúng');
            return Redirect::to('/login')
                ->withInput($request->only('username', 'password'));
        }
    }

    public function logout(){
        Session::put('id_user', null);
        Session::put('firstname', null);
        return Redirect::to('/');
    }

    public function barcode(){
        return view('barcode');
    }
}
