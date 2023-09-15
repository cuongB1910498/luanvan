@extends('pages.dashboard')
@section('user_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="card-header bg-secondary text-center">
                <h2 style="color: white">Danh sách đơn hàng</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:10%;">Mã đơn</th>
                            <th style="width:15%;">Tên người nhận</th>
                            <th style="width:50%;">Địa chỉ</th>
                            <th>SDT</th>
                            <th style="width:3%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td> {{ $row->id_tracking }} </td>
                                <td> {{ $row->name_receive }} </td>
                                <td> {{ $row->address_receive.', '.$row->district_receive.', '.$row->province_receive }}</td>
                                <td> {{ $row->phone_receive}} </td>
                                <td>
                                    <a href="{{URL::to('/view-tracking/'.$row->id_tracking)}}" class="active" ui-toggle-class="">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

           
        </div>
    </div>
@endsection
