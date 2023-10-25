@extends('welcome')
@section('content')
    <div class="row">
        <div class="card mt-3 mb-3 col-sm-10 col-12 offset-sm-1">
            <div class="card-header text-center">
                <h1>Quy Cách đóng gói</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <h2 class="text-center">Đối với hàng hóa thường</h2>
                    <div class="row">
                        <div class="col-sm-5 col-12 offset-sm-4 offset-0">
                            <ul>
                                <li>Nên đóng gói cẩn thận</li>
                                <li>Ưu tiên đóng gói bằng hộp giấy để đảm bảo an toàn hơn</li>
                                <li>Các trường hợp còn lại, hãy đảm bảo đóng gói chắt chắn</li>
                            </ul>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-8 offset-2"><img src="{{asset('/public/frontend/images/DongGoiThuong.png')}}" alt="" width="100%"></div>
                    </div>
                    <h2 class="mt-3 mb-3 text-center">Đối với hàng hóa dễ vỡ</h2>
                    <div class="row">
                        <div class="col-sm-5 col-12 offset-sm-4">
                            <ul>
                                <li>Nên có một lớp đệm chống sốc bao ngoài hàng hóa</li>
                                <li>Nên dán loại bằng keo cảnh báo "Hàng Dễ Vỡ" bên ngoài hộp</li>
                                <li>Đảm bảo hộp chắt chắn nhất có thể, đệp những hạt giảm sốc kết hợp túi chóng sốc,...</li>
                            </ul>
                        </div>

                        
                    </div>
                    <div class="row">
                        <div class="col-8 offset-2">
                            <img src="{{asset('/public/frontend/images/DeVo_1.png')}}" alt="" width="100%">
                            <img src="{{asset('/public/frontend/images/DeVo_2.png')}}" alt="" width="100%">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection