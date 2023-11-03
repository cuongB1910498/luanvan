<?php

namespace App\Imports;

use Illuminate\Support\Facades\Session;

use App\TrackingNumberModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class FirstSheetImport implements ToCollection, WithHeadingRow
{
    protected $address_sending;

    public function __construct($address_sending)
    {
        $this->address_sending = $address_sending;
    }
    public function collection(Collection $rows)
    {
        $address_sending = $this->address_sending;
        //print_r($address_sending);
        $province_sent = $address_sending['province_sent'];
        $district_sent = $address_sending['district_sent'];
        $address_sent = $address_sending['address_sent'];
        $name_sent = $address_sending['name_sent'];
        $phone_sent = $address_sending['phone_sent'];
        $i = 0;
        //parse_str

        //get rannk
        $get_rank = DB::table('users')
            ->join('tbl_rank', 'tbl_rank.id_rank', '=', 'users.id_rank')
            ->where('id_user', Session('id_user'))
            ->first();
        $disscount_price = $get_rank->rank_disscount;
        foreach($rows as $row) {
            //echo $date = date('Y-m-d H:i:s', time()+$i);          
            //thêm dòng này bởi vì thằng excel nó chạy nhiều dòng khác, mặt dù mấy dòng đó dữ liệu trắng bốc, gây ra hiện tượng thừa
            if($row['sdt_nguoi_nhan'] == '' && $row['ten_nguoi_nhan'] == '' && $row['tinh_nhan'] == ''){
                break;
            }
            $id_tracking = 'VN'.time()+$i;
            $get_id_province = DB::table('tbl_province')
                ->where('province_name', 'like', '%'.$row['tinh_nhan'].'%')->first();
            $province_receive = $get_id_province->id_province;
            
            //lấy district_receive
            $get_id_district = DB::table('tbl_district')
                ->where('district_name', 'like', '%'.$row['huyen_nhan'].'%')
                ->where('id_province', '=', $province_receive)
                ->first();
            $district_receive = $get_id_district->id_district;

            //echo $province_sent;
            switch($row['dich_vu_them']){
                case "1":
                    $phi_them = 0;
                    break;
                case "2":
                    $phi_them = 8000;
                    break;
                case "3":
                    $phi_them = 8000;
                    break;
                case "4":
                    $phi_them = 20000;
                    break;
                case "5":
                    $phi_them = 10000;
                    break;
                case "6":
                    $phi_them = 5000;
                    break;
                default: $phi_them = 0;
            }
            //echo $province_sent.' '.$province_receive.'</br>';
            
            
            if($province_sent == $province_receive){
                if($row['trong_luong'] <=500){
                    $tong_gia = 20000 + $phi_them;
                }elseif($row['trong_luong'] >500 && $row['trong_luong']<=1000){
                    $tong_gia = 25000 + $phi_them;
                }elseif($row['trong_luong'] >1000 && $row['trong_luong']<=3000){
                    $tong_gia = 30000 + $phi_them;
                }elseif($row['trong_luong']>3000){
                    $tong_gia = 30000 + ($row['trong_luong'] - 3000)*15;
                }        
            }else{
                if($row['trong_luong'] <=500){
                    $tong_gia = 25000 + $phi_them;
                }elseif($row['trong_luong'] >500 && $row['trong_luong']<=1000){
                    $tong_gia = 30000 + $phi_them;
                }elseif($row['trong_luong'] >1000 && $row['trong_luong']<=3000){
                    $tong_gia = 40000 + $phi_them;
                }elseif($row['trong_luong']>3000){
                    $tong_gia = 40000 + ($row['trong_luong'] - 3000)*15;
                }
            }
            echo $tong_gia;
            // echo $id_tracking;
            // echo $disscount_price.'</br>';
            
            TrackingNumberModel::create([
                'id_tracking' => $id_tracking,
                'address_sent' => $address_sent, 
                'province_sent' => $province_sent,
                'district_sent'=>$district_sent,
                'name_sent'=>$name_sent,
                'phone_sent'=>$phone_sent,
                'address_receive'=>$row['dia_chi_nhan'],
                'district_receive'=>$district_receive,
                'province_receive'=>$province_receive,
                'name_receive'=>$row['ten_nguoi_nhan'],
                'phone_receive'=>$row['sdt_nguoi_nhan'],
                'img_receive'=>'',
                'type_sending'=>$row['loai_chuyen_phat'],
                'describe_tracking'=>$row['mo_ta'],
                'demension'=>$row['kich_thuoc'],
                'weight'=>$row['trong_luong'],
                'tracking_price'=>$tong_gia - $disscount_price,// tính toán trước khi chèn vào
                'cod'=>$row['thu_ho'],
                'id_extra_service'=>$row['dich_vu_them'],
                'id_user'=>Session::get('id_user'), // lấy được id_người dùng mà không cần nhập
                'id_status'=>'1',// mặc định được khởi tạo là 1
                'tracking_created_at'=>now(),
            ]);
            $i++;
        }
    }
   

}