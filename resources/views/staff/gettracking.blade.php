@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        <div class="row mb-3">
            <h2>Lấy đơn nhập Trạm</h2>
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
                    @if (!$tracking->isEmpty())
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
                        <tr><td colspan="4" class="text-center">Hiện tại không có đơn nào được tạo!</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        
    </div>
@endsection