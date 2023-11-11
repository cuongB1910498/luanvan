@extends('staff.dashboard')
@section('staff-content')
    @if (Session::get('msg_role'))
    <div class="alert bg-warning text-center"><h4 style="color:white">Bạn Không Có quyền truy cập</h4></div>  
    @endif
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>{{$info->station_name}}</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="https://res.cloudinary.com/dx3ymfyd4/image/upload/v1699267502/user_avt_iyg1eq.png" alt="" width="100%" height="200px">
                            </div>
                            <div class="col-sm text-center">
                                <h4>Nhân viên: {{$info->staff_name}}</h4>
                                <p>Chức vụ: {{$info->posision_name}}</p>
                                <p>Điện thoại: {{$info->staff_phone}}</p>
                                <p>Mã NV: {{$info->id_staff}}</p>
                                <div class="row justify-content-center"> 
                                @php
                                    echo DNS1D::getBarcodeHTML(strval($info->id_staff), 'C128', 2,40);
                                @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection