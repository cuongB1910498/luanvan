@extends('admin.dashboard')
@section('admin_content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-sm-8">
                @if (Session('success'))
                    <div class="alert alert-success">{{Session('success')}}</div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped text-center">
                            <tr>
                                <td>Hệ thống tự động tính vào 0:00 vào ngày 1 hằng tháng</td>
                            </tr>
                            <tr>
                                <td>Thực hiện thử công: <a href="{{URL::to('/admin/process-salary')}}" class="btn btn-primary">Quyết toán</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection