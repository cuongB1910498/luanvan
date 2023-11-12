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
use Illuminate\Support\Facades\Artisan;
use Spatie\Backup\Helpers\RightAlignedTableStyle;

class SalaryController extends Controller
{
    public function AuthStaff(){
        $id_staff = Session('id_staff');
        $check_staff = DB::table('staff')->where('id_staff', $id_staff)
            ->first();
        if(!$check_staff) return abort(404);
    }

    public function Authadmin(){
        if(Session('admin_id') == null){
            abort(404);
        }
    }
    public function bonusStaff(){
        $this->AuthStaff();
        $select_staff = DB::table('staff')
        ->join('tbl_posisions','tbl_posisions.id_posision','=','staff.id_posision')
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
            'status'=>0,
        ]);
        if($insert){
            return redirect('/staff/bonus-staff')->with('success','Thêm thưởng thành công!');
        }else{
            return redirect('/staff/bonus')->with('error','Đã có lỗi xảy ra!')->withInput(request()->all());
        }
    }

    public function reportSalary(){
        $this->AuthStaff();
        $this_month = Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m');
        $last_month = Carbon::today('Asia/Ho_Chi_Minh')->subMonth()->format('Y-m');
        $month_sub_2 = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(2)->format('Y-m');
        $month_sub_3 = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(3)->format('Y-m');
        $month_sub_4 = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(4)->format('Y-m');
        $month_sub_5 = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(5)->format('Y-m');
        $month_sub_6 = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(6)->format('Y-m');

        $get_salary = DB::table('tbl_salary')
        ->join('staff','staff.id_staff','=','tbl_salary.id_staff')
        ->join('tbl_posisions','tbl_posisions.id_posision','=','staff.id_posision')
        ->where('name_part_salary', $last_month)
        ->where('tbl_salary.id_staff', Session('id_staff'))
        ->first();
        $basic_salary = DB::table('basic_salary')->where('hieu_luc', 1)->first();

        $get_bonus = DB::table('tbl_bonus')->where('id_staff', Session('id_staff'))->where('month_bonus', $last_month)->where('status',1)->get();
        // $get_bonus_sub_1 = DB::table('tbl_salary')->where('id_staff', Session('id_staff'))->where('name_part_salary', $last_month)->first();
        // $get_bonus_sub_2 = DB::table('tbl_salary')->where('id_staff', Session('id_staff'))->where('name_part_salary', $month_sub_2)->first();
        // $get_bonus_sub_3 = DB::table('tbl_salary')->where('id_staff', Session('id_staff'))->where('name_part_salary', $month_sub_3)->first();
        // $get_bonus_sub_4 = DB::table('tbl_salary')->where('id_staff', Session('id_staff'))->where('name_part_salary', $month_sub_4)->first();
        // $get_bonus_sub_5 = DB::table('tbl_salary')->where('id_staff', Session('id_staff'))->where('name_part_salary', $month_sub_5)->first();
        // $get_bonus_sub_6 = DB::table('tbl_salary')->where('id_staff', Session('id_staff'))->where('name_part_salary', $month_sub_6)->first();
        // if($get_bonus_sub_1 == null){ 
        //     $total_1 = 0;
        // }else{
        //     $total_1 = $get_bonus_sub_1->total;
        // }

        // if($get_bonus_sub_2 == null){ 
        //     $total_2 = 0;
        // }else{
        //     $total_2 = $get_bonus_sub_2->total;
        // }

        // if($get_bonus_sub_3 == null){ 
        //     $total_3 = 0;
        // }else{
        //     $total_3 = $get_bonus_sub_3->total;
        // }

        // if($get_bonus_sub_4 == null){ 
        //     $total_4 = 0;
        // }else{
        //     $total_4= $get_bonus_sub_4->total;
        // }

        // if($get_bonus_sub_5 == null){ 
        //     $total_5 = 0;
        // }else{
        //     $total_5= $get_bonus_sub_5->total;
        // }

        // if($get_bonus_sub_6 == null){ 
        //     $total_6 = 0;
        // }else{
        //     $total_6= $get_bonus_sub_6->total;
        // }
        $data = [];
        for($i = 6; $i>=1; $i--){
            $sub_month = Carbon::today('Asia/Ho_Chi_Minh')->subMonth($i)->format('Y-m');
            $get_bonus_sub = DB::table('tbl_salary')->where('id_staff', Session('id_staff'))->where('name_part_salary', $sub_month)->first();
            if($get_bonus_sub != null){
                $data[] = $get_bonus_sub->total;
            }else{
                $data[] = 0;
            }
        }
        // $get_bonus_sub_1->total != null ? $get_bonus_sub_1->total : 0;
        // $get_bonus_sub_2->total != null ? $get_bonus_sub_2->total : 0;
        // $get_bonus_sub_3->total != null ? $get_bonus_sub_3->total : 0;
        // $get_bonus_sub_4->total != null ? $get_bonus_sub_4->total : 0;
        // $get_bonus_sub_5->total != null ? $get_bonus_sub_5->total : 0;
        // $get_bonus_sub_6->total != null ? $get_bonus_sub_6->total : 0;
        //$data = [$total_6, $total_5, $total_4, $total_3, $total_2, $total_1];
        $lable = [$month_sub_6, $month_sub_5, $month_sub_4, $month_sub_3, $month_sub_2, $last_month];
        print_r($data);
        $view_last_month = Carbon::today('Asia/Ho_Chi_Minh')->subMonth()->format('m/Y');
        return view('staff.reportsalary', [
            'get_salary'=>$get_salary,
            'basic_salary'=>$basic_salary,
            'get_bonus'=>$get_bonus,
            'last_month'=>$view_last_month,
        ])->with(compact('data', 'lable'));
    }

    public function processAllStaffSalary(){
        return view('admin.pages.processsalary');
    }

    public function acceptBonus(){
        $get_bonus = DB::table('tbl_bonus')
        ->join('staff','staff.id_staff','=','tbl_bonus.id_staff')
        ->join('tbl_post_station', 'tbl_post_station.id_station', '=', 'staff.id_station')
        ->join('tbl_posisions','tbl_posisions.id_posision','=','staff.id_posision')
        ->where('status', 0)->get();
        return view('admin.pages.acceptbonus', ['get_bonus'=>$get_bonus]);
    }

    public function processSalary(){
        $this->Authadmin();
        Artisan::call('salary:command');
        return Redirect::to('/process-all-staff-salary')->with('success', 'Quyết toán thành công!');
    }

    public function accepted($id_bonus){
        $this->Authadmin();
        $accept = DB::table('tbl_bonus')->where('id_bonus', $id_bonus)->update(['status'=> 1]);
        if($accept){
            return redirect('/accept-bonus')->with('accept','Chấp nhận thành công!');
        }
        return redirect('/accept-bonus')->with('error','Đã có lỗi xảy ra!');
    }

    public function denied($id_bonus){
        $this->Authadmin();
        $accept = DB::table('tbl_bonus')->where('id_bonus', $id_bonus)->update(['status'=> -1]);
        if($accept){
            return redirect('/accept-bonus')->with('denied','Từ chối thành công!');
        }else{
            return redirect('/accept-bonus')->with('error','Đã có lỗi xảy ra');
        }
    }
}
