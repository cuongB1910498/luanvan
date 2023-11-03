@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        Thông tin xe của tui
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <th>STT</th>
                    <th>Bao hàng</th>
                    <th>Gửi từ</th>
                    <th>Trọng lượng</th>
                    
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($list_bag as $bag)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$bag->bag_name}}</td>
                            <td>{{$bag->station_name}}</td>
                            <td>12KG</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection