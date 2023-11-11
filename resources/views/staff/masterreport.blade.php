@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-3">
                <div class="card text-white bg-primary mb-3 h-100">
                    <div class="card-header">Tổng số nhân viên</div>
                    <div class="card-body">
                        <h1>8</h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-warning mb-3 h-100">
                    <div class="card-header">Số đơn đang ở trạm</div>
                    <div class="card-body">
                        <h1>89</h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-success mb-3 h-100">
                    <div class="card-header">Số đơn chờ giao</div>
                    <div class="card-body">
                        <h1>76</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-danger mb-3 h-100">
                    <div class="card-header">Số đơn chờ lấy</div>
                    <div class="card-body">
                        <h1>54</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        Doanh số tháng
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

    new Chart(ctx, {
        type: 'polarArea',
        data: {
        labels: ['6/2023', '7/2023', '8/2023', '9/2023', '10/2023', '11/2023'],
        datasets: [{
            label: 'Đơn',
            data: [320, 239, 338, 299, 287, 308],
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