@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
       <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card">
                <div class="card-header text-center"><h3>Thu nhập tháng {{$last_month}}</h3></div>
                <div class="card-body row justify-content-center">
                    <div class="col-sm-10">
                        <table class="table table-striped">
                            @if (!$get_salary)
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center">Hiện chưa có quyết toán!</th>
                                    </tr>    
                                </tbody>  
                            @else
                                <tbody>
                                    <tr>
                                        <td>Mức lương:</td>
                                        <td>{{$get_salary->lvl_salary}}</td>
                                    </tr>
                                    <tr>
                                        <td>Lương cơ bản:</td>
                                        <td>{{number_format($basic_salary->gia, 0, ',', '.').' VND'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Thưởng:</td>
                                        <td>{{number_format($get_salary->total_bonus, 0, ',', '.').' VND'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Khấu trừ:</td>
                                        <td>{{number_format($get_salary->total_deduct, 0, ',', '.').' VND'}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tổng cộng</th>
                                        <th>{{number_format($get_salary->total, 0, ',', '.').' VND'}}</th>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-3 mt-5">
            <div class="col-sm-8">
                <table class="table table-light table-striped">
                    <thead>
                        <th>STT</th>
                        <th>Mức thưởng</th>
                        <th>Nội dung</th>
                    </thead>
                    <tbody>
                        @if (!$get_bonus->isEmpty())
                        @php
                            $i  = 1;
                        @endphp
                        @foreach ($get_bonus as $row)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{'+'.number_format($row->prize_money, 0, ',', '.').' VND'}}</td>
                                <td>{{$row->reason}}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                        @else 
                       
                        <tr>
                            <td colspan="3" class="text-center">Hiện không có thưởng!</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row justify-content-center mb-3 mt-3">
            <div class="col-sm-8">
                <table class="table table-light table-striped">
                    <thead>
                        <th>STT</th>
                        <th>Mức khấu trừ</th>
                        <th>Nội dung</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>-100.000VND</td>
                            <td>Nghỉ 1,5 ngày</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">Hiện không có Khấu trừ!</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-3 mt-5 justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        Thu nhâp các tháng trước
                    </div>
                    <div class="card-body"> 
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
       </div>
       
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const ctx = document.getElementById('myChart');
    var data = @json($data);
    var label = @json($lable);
    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: label,
        datasets: [{
            label: 'Tổng: ',
            data: data,
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
    </script>
@endsection