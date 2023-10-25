@extends('staff.dashboard')
@section('staff-content')
    <div class="container mb-3">
        <h2>Nhận đơn để giao</h2>
        <table class="table table-striped">
            <thead>
                <th style="width:35%">Địa chỉ nhận</th>
                <th>Tên người nhận</th>
                <th>SDT</th>
                <th style="width:25%">Thao tác</th>
            </thead>
            <tbody>
                @if ($deliver->isEmpty())
                <tr><td colspan="4" class="text-center">Hiện không có đơn nào ở trạm</td></tr>
                   
                @else
                @foreach ($deliver as $item)
                <tr>
                    <td>{{$item->address_receive}}</td>
                    <td>{{$item->name_receive}}</td>
                    <td>{{$item->phone_receive}}</td>
                    <td><a href="{{URL::to('/staff/get-tracking-process/'.$item->id_tracking.'?get=todeliver')}}" class="btn btn-primary">lấy</a></td>
                </tr>
            @endforeach
                @endif
                
            </tbody>
        </table>
    </div>
@endsection