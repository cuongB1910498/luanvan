@extends('pages.dashboard')
@section('user_content')
    <div class="container">
        @if(Session('success'))
            <div class="alert alert-success"><label>{{Session('success')}}</label></div>
        @endif
        @if(Session('error'))
            <div class="alert alert-danger"><label>{{Session('error')}}</label></div>
        @endif
        @if($get_info)
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Hóa đơn thanh toán VNPay của bạn</h3>
                    </div>

                    <div class="card-body text-center">
                        <div class="mb-3">
                            <button class="btn btn-lg btn-success" style="border-radius:60px"><i class="bi bi-check"></i></button>
                            <h2>Thanh toán thành công!</h2>
                        </div>
                        <p>Mã Vận đơn: {{$get_info->id_tracking}}</p>
                        <p>Số tiền: {{number_format($get_info->vnp_Amount, 0, '.', ',').' VND'}}</p>
                        <p>Mã giao dịch: {{$get_info->vnp_BankTranNo}}</p>
                        <p>Ngày thanh toán: {{$get_info->vnp_PayDate}}</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-danger">Đã có lỗi xảy ra!</div>
        @endif
    </div>
@endsection