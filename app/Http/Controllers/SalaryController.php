<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;

class SalaryController extends Controller
{
    public function AuthStaff(){
        $id_staff = Session('id_staff');
        $check_staff = DB::table('staff')->where('id_staff', $id_staff)
            ->first();
        if(!$check_staff) return abort(404);
    }
    public function bonusStaff(){
        $this->AuthStaff();
        $select_staff = DB::table('staff')
        ->join('tbl_posisions','tbl_posisions.id_posision','=','staff.id_posision')
        ->where('id_staff', '<>' ,Session('id_staff'))
        ->where('id_station', Session('id_station'))
        ->get();
        return view('staff.bonusstaff', ['get_staff'=>$select_staff]);
    }

    public function bonusProcess(Request $request){
        $this->AuthStaff();
        $request->validate([
            'staff'=>'required',
            'prize_money'=>'required',
            'reason'=>'required'
        ],[
            'staff.required'=>'Bạn chưa chọn nhân viên!',
            'prize_money.required'=>'Bạn chưa nhập mức thưởng!',
            'reason.required'=>'Bạn chưa nhập nội dung thưởng!'
        ]);
        $this_month = Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m');
        $insert = DB::table('tbl_bonus')->insert([
            'id_staff'=>$request->staff,
            'prize_money'=>$request->prize_money,
            'reason'=>$request->reason,
            'month_bonus'=>$this_month,
        ]);
        if($insert){
            return redirect('/staff/bonus-staff')->with('success','Thêm thưởng thành công!');
        }else{
            return redirect('/staff/bonus')->with('error','Đã có lỗi xảy ra!')->withInput(request()->all());
        }
    }
}
