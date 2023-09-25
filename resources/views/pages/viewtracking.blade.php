@extends('pages.dashboard')
@section('user_content')
    <div class="row mt-3 mb-3">
        <div class="col-lg-10 col-12 offset-lg-1 row">
            <div class="row">
                <h2 class="col-10">Mã vận đơn: {{ $id_tracking }}</h2>
                <a target="_blank" href="{{URL::to('/pdf/'.$id_tracking)}}" class="col-1 btn btn-success">In Đơn</a>
            </div>
            <h2 class="text-center">Mẫu in</h2>
            <div class="row print_preview">
                
                <div class="row header-print">
                    <div class="col-4"> 
                        @php
                            echo DNS1D::getBarcodeHTML($id_tracking, 'C128', 2,40);
                        @endphp
                        <p>{{$id_tracking}}</p>
                    </div>

                    <div class="col-6">
                        <h1>Thyn Express</h1>
                        <p>Dịch vụ vận chuyển uy tín</p>
                    </div>
                    <div class="col-2">
                        @php
                            echo DNS2D::getBarcodeHTML($id_tracking, 'QRCODE', 4,4);
                        @endphp
                    </div>
                </div>
                <div class="row main-print">
                    <div class="col-6">
                        <h3>Bên Gửi:</h3>
                        <p>{{$tracking->name_sent}} - {{$tracking->address_sent}}, {{$sender->district_name}}, {{$sender->province_name}}</p>
                        <p>{{$tracking->phone_sent}}</p>
                    </div>
                    <div class="col-1"></div>
                    <div class="col">
                        <h3>Bên Nhận:</h3>
                        <p>{{$receive->name_receive}} - {{$receive->address_receive}}, {{$receive->district_name}}, {{$receive->province_name}}</p>
                        <p>{{$tracking->phone_receive}}</p>
                    </div>
                </div>
                <div class="row footer-print">
                    <div class="row text-center">
                        <p>Nội dung hàng hóa: {{$tracking->describe_tracking}}</p>
                    </div>
                    <div class="row">
                        <h2>COD: {{number_format($tracking->cod, 0, ',', '.')}} VND</h2>
                    </div>
                </div>
            </div>
            <h2 class="text-center mt-3">Trạng thái</h2>
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Thời gian</th>
                    
                  </tr>
                </thead>
                <tbody>
                    @foreach ($get_tracking as $row)
                        <tr>
                            <td>{{ $row->note }}</td>
                            <td> {{ $row->created_at }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection