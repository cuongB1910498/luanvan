@extends('admin.dashboard')
@section('admin_content')
    <div class="container">
        @if (Session('accept'))
            <div class="alert alert-success">{{Session('accept')}}</div>
        @endif
        @if (Session('denied'))
            <div class="alert alert-warning">{{Session('denied')}}</div>
        @endif
        <div class="alert alert-secondary text-center mb-3"><h3>Duyệt thưởng</h3></div>
        <div class="row justify-content-center mt-3">
            <div class="col-sm-12">
                <table class="table table-striped">
                    <thead>
                        <th>STT</th>
                        <th>Tên nhân viên</th>
                        <th>Trạm công tác</th>
                        <th>Chức vụ</th>
                        <th>Mức thưởng</th>
                        <th>Nội dung</th>
                        <th>Xét</th>
                    </thead>
                    <tbody>
                        @if ($get_bonus->isEmpty())
                            <tr><td colspan="7" class="text-center">Hiện không có mức thưởng nào cần phế duyệt!</td></tr>
                        @else
                        @php
                            $i = 1;
                        @endphp
                            @foreach ($get_bonus as $row)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$row->staff_name}}</td>
                                <td>{{$row->station_name}}</td>
                                <td>{{$row->posision_name}}</td>
                                <td>{{number_format($row->prize_money, 0, ',', '.').' VND'}}</td>
                                <td>{{$row->reason}}</td>
                                <td>
                                    <a href="{{URL::to('/admin/bonus/accepted/'.$row->id_bonus)}}" class="btn btn-primary" onclick="return confirm('Bạn chắt chắn xác nhận duyệt thưởng ?');">Duyệt</a>
                                    <a href="{{URL::to('/admin/bonus/denied/'.$row->id_bonus)}}" class="btn btn-danger" onclick="return confirm('Bạn chắt chắn muốn từ chối thưởng ?');">Từ chối</a>
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