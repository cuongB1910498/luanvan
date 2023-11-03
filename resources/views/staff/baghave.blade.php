@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        Thông tin xe của tui
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <th>STT</th>
                    <th>Mã đơn</th>
                    <th>Gửi từ</th>
                    
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($list_tracking as $tracking)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$bag->bag_name}}</td>
                            <td><a href="{{URL::to('/staff/bag/'.$bag->id_bag)}}"><i class="bi bi-eye primary"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection