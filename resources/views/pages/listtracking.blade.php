@extends('pages.dashboard')
@section('user_content')
    <div class="table-agile-info">
        <div class="row mb-3 mt-3">
            <div class="col-sm col-4 offset-sm-1 mb-3">
                @if (request()->input('sort'))
                <a href="{{URL::to('/list-tracking')}}" class="btn btn-outline-primary">Tất cả đơn</a>
                @else
                <a href="{{URL::to('/list-tracking')}}" class="btn btn-primary">Tất cả đơn</a>
                @endif
            </div>

            <div class="col-sm col-4 mb-3">
                @if (request()->input('sort') && request()->input('sort') == 'created')
                <a href="{{URL::to('/list-tracking?sort=created')}}" class="btn btn-primary">Chưa lấy</a>
                @else 
                <a href="{{URL::to('/list-tracking?sort=created')}}" class="btn btn-outline-primary">Chưa lấy</a>
                @endif
            </div>

            <div class="col-sm col-4 mb-3">
                @if (request()->input('sort') && request()->input('sort') == 'process')
                    <a href="{{URL::to('/list-tracking?sort=process')}}" class="btn btn-primary">Đang giao</a>
                @else 
                    <a href="{{URL::to('/list-tracking?sort=process')}}" class="btn btn-outline-primary">Đang giao</a>
                @endif
                
            </div>

            <div class="col-sm col-4 mb-3">
                @if (request()->input('sort') && request()->input('sort') == 'complete')
                    <a href="{{URL::to('/list-tracking?sort=complete')}}" class="btn btn-primary">Thành công</a>
                @else 
                    <a href="{{URL::to('/list-tracking?sort=complete')}}" class="btn btn-outline-primary">Thành công</a>
                @endif
                
            </div>

            <div class="col-sm col-4 mb-3">
                @if (request()->input('sort') && request()->input('sort') == 'fail')
                    <a href="{{URL::to('/list-tracking?sort=fail')}}" class="btn btn-primary">Trả hoàn</a>
                @else 
                    <a href="{{URL::to('/list-tracking?sort=fail')}}" class="btn btn-outline-primary">Trả hoàn</a>
                @endif
                
            </div>
        </div>
        @if($data->isEmpty())
            <div class="alert alert-warning">Hình như chưa có đơn hàng nào!</div>
        @else
        <div class="panel panel-default">
           

            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                        <tr>
                            <th style="width:10%;">Mã đơn</th>
                            <th style="width:15%;">Tên người nhận</th>
                            <th style="width:50%;">Địa chỉ nhận</th>
                            <th>SDT</th>
                            <th style="width:3%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td> {{ $row->id_tracking }} </td>
                                <td> {{ $row->name_receive }} </td>
                                <td> {{ $row->address_receive.', '.$row->district_name.', '.$row->province_name }}</td>
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
        @endif
    </div>
@endsection
