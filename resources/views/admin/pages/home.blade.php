@extends('admin.dashboard')
@section('admin_content')
    <div class="container">
        <h1>Chào mừng đến với ADMIN</h1>
        <div class="row mb-3">
            <div class="col-sm-3">
                <div class="card text-white bg-primary mb-3 h-100">
                    <div class="card-header">Tổng số nhân viên</div>
                    <div class="card-body">
                        <h1>{{ $count_staff }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-warning mb-3 h-100">
                    <div class="card-header">Tổng số Trạm</div>
                    <div class="card-body">
                        <h1>{{ $count_station }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-white bg-success mb-3 h-100">
                    <div class="card-header">Tổng số Xe Vận chuyển</div>
                    <div class="card-body">
                        <h1>{{ $count_truck }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-danger mb-3 h-100">
                    <div class="card-header">Tổng số đơn hàng</div>
                    <div class="card-body">
                        <h1>230</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 mt-3">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        ChartJs1
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        ChartJs1
                    </div>
                    <div class="card-body">
                        <canvas id="myChart1"></canvas>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');
        const mychart = document.getElementById('myChart1');

        var data = @json($data);
        var label = @json($lable);
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: '# of Votes',
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

        new Chart(mychart, {
            type: 'bar',
            data: {
                labels: label,
                datasets: [{
                    label: '# of Votes',
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
