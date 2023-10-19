<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use APP\Http\Requests;
use Psy\Command\WhereamiCommand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
//use App\Imports\ImportTest;
use App\Imports\ImportTracking;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\TrackingNumberModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Exports\VatExport;
class ExportVatController extends Controller
{
    public function Auth_login(){
        $id_user = Session::get('id_user');
        if($id_user){
            return Redirect::to('/user');
        }else{
            return abort(404);
        }
    }
    public function vatPreview(){
        $this->Auth_login();
        $today = Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $last_month = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(1)->format('m'); // Lấy tháng hiện vừa rồi
        $this_mouth = now()->format('m');
        $this_year = now()->format('Y');

        $trackingCounts = DB::table('tbl_tracking_number')
            ->select('tracking_price', DB::raw('count(*) as count'))
            ->whereMonth('tracking_created_at', $this_mouth)
            ->whereYear('tracking_created_at', $this_year)
            ->groupBy('tracking_price')
            ->get();

        $get_company_info = DB::table('company_info')->where('id_user', Session('id_user'))->first();
        return view('pages.vatpreview', ['tracking'=>$trackingCounts, 'last_month'=>$last_month, 'this_year'=>$this_year, 'company'=>$get_company_info]);
    }

    public function sentMailVat(Request $request){
        $this->Auth_login();
        $today = Carbon::today('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $last_month = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(1)->format('m');
        $this_year = now()->format('Y');
        $to_name = "THYNexpress xuat Hoa Don VAT Thang".$last_month.'/'.$this_year;
        $to_email = $request->email;//send to this email

        $data = [
            'ten_nguoi_ban' => 'CONG TY THYNX',
            'dia_chi' => '3/2, Xuân Khánh, Ninh Kiều, Cần Thơ',
            'ngay_hoa_don' => $today,
            'cong_ty_sddv' => '',
            'ma_so_thue' => '',
            'cty_dc' => '',
        ]; //gửi dữ liệu qua trang bên kia để định dạng cho đẹp
    
        Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('test mail nhé');//send this mail with subject
            $message->from($to_email,$to_name);//send from this mail
        });

    }

    public function createCompanyInfo(Request $request){
        $this->Auth_login();
        $messages = [
            'company_name.required' => 'Bạn chưa nhập Tên Công Ty!',
            'company_tax.required' => 'Bạn chưa nhập mã só thuế !',
            'company_address.required' => 'Bạn chưa nhập địa chỉ !',
            'company_email.required' => 'Bạn chưa nhập email !',
            'agree.required' => 'Bạn phải đồng ý quy dịnh của chúng tôi !',
        ];
        $request->validate([
            'company_name'=>'required',
            'company_tax'=>'required', 
            'company_address'=>'required',
            'company_email'=>'required',
            'agree'=>'required',
        ], $messages);

        $data =[
            'company_name'=>$request->company_name,
            'company_tax'=>$request->company_tax,
            'company_address'=>$request->company_address,
            'company_email'=>$request->company_email,
            'id_user'=> Session('id_user'),
        ];
        
       // print_r($data);
        $insert = DB::table('company_info')->insert($data);

        if($insert){
            return redirect('/vat-preview');
        }
    }

    public function exportVat(){
        $this->Auth_login();
        $today = Carbon::today('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $last_month = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(1)->format('m'); // Lấy tháng hiện vừa rồi
        $this_mouth = now()->format('m');
        $this_year = now()->format('Y');

        $trackingCounts = DB::table('tbl_tracking_number')
            ->select('tracking_price', DB::raw('count(*) as count'))
            ->whereMonth('tracking_created_at', $this_mouth)
            ->whereYear('tracking_created_at', $this_year)
            ->groupBy('tracking_price')
            ->selectRaw('tracking_price * count(*) as total')
            ->get();
        
        
        $data = $trackingCounts->toArray();
        
        $get_company_info = DB::table('company_info')->where('id_user', Session('id_user'))->first();
        $additionalInfo = $get_company_info;
        $name_file ='hoadon_'.$last_month.'-'.$this_year.'.xlsx';
        
        return Excel::download(new VatExport($data, $additionalInfo), $name_file);  
    }
}
