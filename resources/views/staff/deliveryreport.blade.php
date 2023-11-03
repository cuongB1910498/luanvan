@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        <h1 class="text-center">Thống kê</h1>
        <div class="row mb-3 mt-3">
            <div class="col-sm-6 mb-3">
                <div class="card">

                    <div class="card-header">
                        Thống kê hôm nay
                    </div>
                    <div class="card-body">
                        <table class="table" style="height:280px;">
                            <tr>
                                <td><h2>Đã giao: </h2></td>
                                <td><h2>{{$get_report->total_tracking}} đơn</h2></td>
                            </tr>
                            <tr>
                                <td><h2>Thu nhập:</h2> </td>
                                <td><h2>{{number_format($get_report->total_tracking*7000, 0, ',','.')}} VND</h2></td>
                            </tr>
                            <tr>
                                <td><h2>Tiền hàng: </h2></td>
                                <td><h2>{{number_format($get_report->total_amount, 0, ',','.')}} (Phải nộp)</h2></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-sm-6 mb-3">
                <div class="card">

                    <div class="card-header">
                        Thu nhập
                    </div>

                    <div class="card-body">
                        <div style="height:300px;">
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
    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ['5/2023', '6/2023', '7/2023', '8/2023', '9/2023', '10/2023'],
        datasets: [{
            label: 'Số đơn',
            data: [934, 1143, 1156, 1047, 1048, 1054],
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
