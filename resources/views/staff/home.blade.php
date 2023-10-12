@extends('staff.dashboard')
@section('staff-content')
    @if (Session::get('msg_role'))
    <div class="alert bg-warning text-center"><h4 style="color:white">Bạn Không Có quyền truy cập</h4></div>  
    @endif
    <div class="container">
         Trạm nhận 10 đơn, chưa nhận 10 đơn
    </div>
@endsection