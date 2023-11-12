<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
class ProcessSalary extends Command
{
    protected $signature = 'salary:command';
    protected $description = 'Tinh toan luong cho toan bo nhan vien';
    public function handle()
    {
        $get_all_staff = DB::table('staff')
        ->join('tbl_posisions','tbl_posisions.id_posision','=','staff.id_posision')
        ->where('is_working', 1)
        ->get();
        $last_month = Carbon::today('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
        $basic_salary = DB::table('basic_salary')->where('hieu_luc', 1)->first();
        foreach ($get_all_staff as $key => $row) {
            $get_bonus = DB::table('tbl_bonus')->where('id_staff', $row->id_staff)->where('status', 1)->get();
            $total_bonus = 0;
            foreach ($get_bonus as $item) {
                $total_bonus += $item->prize_money;
            }
            $insert_salary = DB::table('tbl_salary')->insert([
                'name_part_salary'=>$last_month,
                'total'=>$row->lvl_salary*$basic_salary->gia,
                'id_staff'=>$row->id_staff,
                'total_bonus'=>$total_bonus,
                'total_deduct'=>0,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
        $this->info('Công việc đã được thực hiện thành công!');
    }
}
