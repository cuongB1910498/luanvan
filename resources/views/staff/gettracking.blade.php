@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        <div class="row mb-3">
            <h2>Lấy đơn nhập kho</h2>
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif

            <table class="table table-striped">
                <thead >
                    <th style="width:35%">Địa chỉ</th>
                    <th>Tên người gửi</th>
                    <th>SDT</th>
                    <th style="width:25%">Thao tác</th>
                </thead>
                <tbody>
                    {{-- <tr><td colspan="4" class="text-center">hiện không có đơn</td></tr> --}}
                    @if (!empty($tracking))
                        @foreach ($tracking as $row)
                            <tr>
                                <td>{{$row->address_sent}}</td>
                                <td>{{$row->name_sent}}</td>
                                <td>{{$row->phone_sent}}</td>
                                <td>
                                    <a class="btn btn-primary me-2" href="{{URL::to('/staff/get-tracking-process/'.$row->id_tracking.'?get=success')}}">Lấy</a>
                                    <a class="btn btn-warning" href="{{URL::to('/staff/get-tracking-process/'.$row->id_tracking.'?get=fail')}}">lấy thất bại!</a>
                                </td>
                            </tr> 
                        @endforeach  
                    @else
                        <tr><td colspan="4" class="text-center">hiện không có đơn</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="row mb-3">
            <h2>Lấy đơn để giao</h2>
            <table class="table table-striped">
                <thead>
                    <th style="width:35%">Địa chỉ nhận</th>
                    <th>Tên người nhận</th>
                    <th>SDT</th>
                    <th style="width:25%">Thao tác</th>
                </thead>
                <tbody>
                    @if ($deliver)
                        @foreach ($deliver as $item)
                            <tr>
                                <td>{{$item->address_receive}}</td>
                                <td>{{$item->name_receive}}</td>
                                <td>{{$item->phone_receive}}</td>
                                <td><a href="{{URL::to('/staff/get-tracking-process/'.$item->id_tracking.'?get=todeliver')}}" class="btn btn-primary">lấy</a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4" class="text-center">hiện không có đơn</td></tr>
                    @endif
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection