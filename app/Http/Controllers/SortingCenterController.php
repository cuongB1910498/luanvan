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
use PhpOffice\PhpSpreadsheet\Calculation\Database\DVar;

session_start();
class SortingCenterController extends Controller
{
    public function AuthStaff(){
        $id_staff = Session::get('id_staff');
        if($id_staff){
            return Redirect::to('/staff/');
        }else{
            abort(404);
        }
    }
    public function arriveSC(){
        $this->AuthStaff();
        $get_all_province = DB::table('tbl_province')->get();
        $check_sc = DB::table('staff')
            ->join('tbl_post_station','tbl_post_station.id_station','=','staff.id_station')
            ->where('id_staff', Session('id_staff'))
            ->first();
        foreach( $get_all_province as $province ){
            $today = Carbon::today()->format('Y-m-d');
            $check_bag = DB::table('tbl_bag')
                ->where('id_station', Session('id_station'))
                ->where('date', $today)
                ->where('goto', $province->id_province)
                ->get();
            if($check_bag->isEmpty() && $check_sc->is_SC == 1){
                $create_bag = DB::table('tbl_bag')
                    ->insert(
                        [
                            'bag_name'=> 'Bao đi tỉnh '. $province->province_name,
                            'goto'=> $province->id_province,
                            'id_station'=>Session('id_station'),
                            'date'=>$today,
                            'bag_status'=>1,
                        ]
                    );
            }
        } 
        return view('staff.arrivesc');
    }

    public function processSort(Request $request){
        $today = Carbon::today()->format('Y-m-d');
        $tracking = $request->input('tracking');
        $tracking_list = explode(",", $tracking);
        $get_bag_today = DB::table("tbl_bag")
            ->where('date',$today)
            ->where('id_station', Session('id_station'))
            ->get();
        DB::beginTransaction();
        try{
            foreach($tracking_list as $id_tracking){
                if($id_tracking == '') continue;
                foreach($get_bag_today as $bag){
                    $select_tracking = DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->first();
                    if($bag->goto == $select_tracking->province_receive){
                        DB::table('tbl_tracking_number')->where('id_tracking', $id_tracking)->update(['id_bag'=>$bag->id_bag]);
                    }
                }
                DB::table('located')->insert([
                    'note'=> 'Đã đến trung tâm phân loại KV1',
                    'LC_status'=>4,
                    'id_tracking'=>$id_tracking,
                    'id_staff'=>Session('id_staff'),
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
            }
            DB::commit();
            return redirect('/staff/arrive-sc')->with('success', 'Thành công!');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('/staff/arrive-sc')->with('error', 'Có lỗi xảy ra, hãy kiểm tra lại!')->withInput($request->only('tracking'));
        }
    }
}

