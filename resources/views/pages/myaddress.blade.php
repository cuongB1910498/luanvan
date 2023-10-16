@extends('pages.dashboard')
@section('user_content')

<div class="container">
    @if (Session('success'))
        <div class="alert alert-success">{{Session('success')}}</div>
    @endif
    @if (Session('error'))
        <div class="alert alert-danger">{{Session('error')}}</div>
     @endif
    @if ($get_address->isEmpty())
        <h2 class="alert alert-warning text-center">Bạn chưa có địa chỉ nào</h2>
        <a href="{{URL::to('/add-address')}}" class="btn btn-primary offset-sm-5">Thêm địa chỉ ngay</a>
    @else
    <h2 class="text-center">Địa chỉ của tôi:</h2>
    <table class="table table-striped">
        <thead>
            <th>STT</th>
            <th>Tên địa chỉ</th>
            <th>Địa chỉ</th>
            <th>Quản lý</th>
        </thead>

        <tbody>
            @php
                $i=1
            @endphp
            @foreach ($get_address as $row)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$row->address_name}}</td>
                    <td>{{$row->address_sent.', '.$row->district_name.', '.$row->province_name}}</td>
                    <td>
                        <a href="{{URL::to('modify-address/'.$row->id_address)}}" class="btn btn-warning">Sửa</a>
                        <a href="{{URL::to('delete-address/'.$row->id_address)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắt muốn xóa địa chỉ này?');">Xóa</a>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection