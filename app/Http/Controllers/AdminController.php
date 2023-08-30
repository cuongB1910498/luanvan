<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use APP\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function dashboard(){
        if(Session::get('admin_id')){
            return view('admin.pages.home');
        }else{
            return Redirect::to('/adminlogin');
        }
        
    }

    public function login(){
        return view('admin.login');
    }

    public function admin_login_process(Request $request){
        $username = $request->username;
        $password = md5($request->password);

        $result = DB::table('users')->where('username', $username)->where('password', $password)->first();
        print_r($result);
        
       if($result){
        Session::put('admin_name', 'admin');
        Session::put('admin_id', $result->id_user);
        return Redirect::to('/admin-dashboard');
       }else{
        Session::put('msg', 'username or password was not correct!');
        return Redirect::to('/adminlogin');
       }
        
    }

    public function logout(){
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/adminlogin');
    }   
}