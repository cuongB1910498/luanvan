@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        <h2>{{$bag->bag_name}}</h2>
        <table class="table">
            <thead>
                <th>Mã Đơn</th>
                <th>Người Gửi</th>
                <th>SDT</th>
                <th>Tỉnh Nhận</th>
            </thead>
            @if(!$tracking->isEmpty())
            <tbody>
                @foreach ($tracking as $row)
                    <tr>
                        <td>{{$row->id_tracking}}</td>
                        <td>{{$row->name_sent}}</td>
                        <td>{{$row->phone_sent}}</td>
                        <td>{{$row->province_name}}</td>
                    </tr>
                @endforeach
            </tbody>
            @else
            <tbody>
                <tr> <td colspan="4" class="text-center">Bao này hiện đang trống rỗng!</td></tr>
            </tbody>
            @endif
        </table>
    </div>
@endsection