<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Exception;

use APP\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class ManagePosision extends Controller
{
    public function add_posision(){
        return view('admin.pages.addposision');
    }

    public function posision_process(Request $request){
        $data = array();
        $data['posision_name']= $request->posision_name;
        $data['lvl_salary'] = $request->lvl_salary;
        
        
        $result = DB::table('tbl_posisions')->insert($data);
        if($result){
            Session::put('msg_posision', 'Added successfully!');
            return Redirect::to('/add-posision');
        }else{
            Session::put('msg_posision', 'An error occurred!');
            return Redirect::to('/add-posision');
        }
    }

    public function posision_list(){
        $posision_list = DB::table('tbl_posisions')->get();
        $manager_list = view('admin.pages.showposision')->with('posision_list', $posision_list);

        return view('admin.dashboard')->with('admin.pages.showposision', $manager_list);
    }

    public function edit_posision($id_posision){
        $edit_posision = view('admin.pages.editposision')->with('edit_posision', DB::table('tbl_posisions')->where('id_posision', $id_posision)->first());
        
        return view('admin.dashboard')->with('admin.pages.editposision', $edit_posision);
    }
    
    public function update_posision(Request $request, $id_posision){
        $data = array();
        $data['id_posision'] = $id_posision;
        $data['posision_name'] = $request->posision_name;
        $data['lvl_salary'] = $request->lvl_salary;
        print_r($data);
        $result = DB::table('tbl_posisions')->where('id_posision', $id_posision)->update($data);
        if($result){
            Session::put('msg_update', 'updated successfully!');
            return Redirect::to('/posision-list');
        }else{
            Session::put('update_error', 'error!');
            return Redirect::to('/update-posision/'.$id_posision);
        }
    }

    public function delete_posision($id_posision){
        $result = DB::table('tbl_posisions')->where('id_posision', $id_posision)->delete();
        if($result){
            return Redirect::to('/posision-list');
        }
    }
}
