@extends('pages.dashboard')
@section('user_content')
    <div class="container user_content">
        <div class="row text-center">
            <h2 class="mb-3">Chào bạn!</h2>
            <p>Mời bạn trãi nghiệm dịch vụ chuyển hàng của ThynExpress</p>
            <div class="tao_don text-center"> 
                <button class="nut_tao"><a href="{{URL::to('/create-tracking')}}"><i class="fa fa-archive"></i> Bắt đầu tạo đơn hàng</a></button>
            </div>

            <div class="tracuu text-center">
                <form action="" method="post">
                    <h2 class="mb-3">Kiểm tra đơn hàng</h2>
                    <div class="form-group">
                        <div class="kiemtradon">
                            <input type="text" name="kiemtradon" class="form-control" style="margin-right: 10px">
                            <button class="btn"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <p>Bạn chỉ có thể tra cứu mã vận đơn của mình, hoặc có thể vào mục</p>
                        <a href="{{URL::to('/list-tracking')}}">Quản lý đơn hàng</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection