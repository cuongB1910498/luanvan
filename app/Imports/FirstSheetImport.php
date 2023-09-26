<?php

namespace App\Imports;

// use App\test;
use App\TrackingNumberModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FirstSheetImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
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
            if($row['tinh_gui'] == $row['tinh_nhan']){
                if($row['trong_luong'] <=500){
                    $tong_gia = 20000 + $phi_them;
                }elseif($row['trong_luong'] >500 && $row['trong_luong'<=1000]){
                    $tong_gia = 25000 + $phi_them;
                }elseif($row['trong_luong'] >1000 && $row['trong_luong']<=3000){
                    $tong_gia = 30000 + $phi_them;
                }elseif($row['trong_luong']>3000){
                    $tong_gia = 30000 + ($row['trong_luong'] - 3000)*15;
                }
            }else{
                if($row['trong_luong'] <=500){
                    $tong_gia = 25000 + $phi_them;
                }elseif($row['trong_luong'] >500 && $row['trong_luong'<=1000]){
                    $tong_gia = 30000 + $phi_them;
                }elseif($row['trong_luong'] >1000 && $row['trong_luong']<=3000){
                    $tong_gia = 40000 + $phi_them;
                }elseif($row['trong_luong']>3000){
                    $tong_gia = 40000 + ($row['trong_luong'] - 3000)*15;
                }
            }
            TrackingNumberModel::create([
                'id_tracking' => 'VN'.time(),
                'address_sent' => $row['dia_chi_gui'], 
                'province_sent' => $row['tinh_gui'],
                'district_sent'=>$row['huyen_gui'],
                'name_sent'=>$row['ten_nguoi_gui'],
                'phone_sent'=>$row['sdt_nguoi_gui'],
                'address_receive'=>$row['dia_chi_nhan'],
                'district_receive'=>$row['huyen_nhan'],
                'province_receive'=>$row['tinh_nhan'],
                'name_receive'=>$row['ten_nguoi_nhan'],
                'phone_receive'=>$row['sdt_nguoi_nhan'],
                'img_receive'=>'',
                'type_sending'=>$row['loai_chuyen_phat'],
                'describe_tracking'=>$row['mo_ta'],
                'demension'=>$row['kich_thuoc'],
                'weight'=>$row['trong_luong'],
                'tracking_price'=>$tong_gia,// tính toán trước khi chèn vào
                'cod'=>$row['thu_ho'],
                'id_extra_service'=>$row['dich_vu_them'],
                'id_user'=>$row['id_nguoidung'], // lấy được id_người dùng mà không cần nhập
                'id_status'=>'1',// mặc định được khởi tạo là 1
            ]);
        }
    }
   

}