@extends('admin.dashboard')
@section('admin_content')
    <div class="container">
        <div class="row justify-content-center">
            @if (Session('success'))
                <div class="alert alert-success">{{Session('success')}}</div>
            @endif

            @if (Session('error'))
                <div class="alert alert-danger">{{Session('error')}}</div>
            @endif
            <div class="col-sm-12">
                <table class="table table-striped" id="myTable">
                    <thead>
                        <th>STT</th>
                        <th>Tài khoản NV</th>
                        <th>Họ tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Nơi công tác</th>
                        <th>Chức vụ</th>
                        <th>QL</th>
                    </thead>
                    <tbody>
                        @if ($staffs->isEmpty())
                            <tr><td colspan="8"></td></tr>
                        @else
                            @php
                                $i =1;
                            @endphp
                            @foreach ($staffs as $row)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$row->staff_username}}</td>
                                    <td>{{$row->staff_name}}</td>
                                    <td>{{$row->staff_phone}}</td>
                                    <td>{{$row->staff_email}}</td>
                                    <td>{{$row->station_name}}</td>
                                    <td>{{$row->posision_name}}</td>
                                    <td>
                                        <a href="{{URL::to('/edit-user/'.$row->id_staff)}}" class="btn btn-danger"><i class="bi bi-person-gear"></i></a>
                                    </td>
                                </tr>
                            @php
                                $i++
                            @endphp
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection