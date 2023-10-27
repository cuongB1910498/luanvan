@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        @if (Session('success'))
            <div class="alert alert-success">{{Session('success')}}</div>
        @endif
        @if (Session('error'))
            <div class="alert alert-danger">{{Session('error')}}</div>
        @endif
        <h2>Đã đến trung tâm phân loại</h2>
        <div class="row">
            <form action="{{URL::to('/staff/process-sort')}}" method="post" class="mb-3 mt-3"> 
                @csrf
                <div class="form-group row mb-3 offset-sm-3">
                    <label for="tracking" class="">Scan: </label>
                    <div class="col-7">
                        <textarea name="tracking" id="tracking" cols="30" rows="10" class="form-control">{{ old('tracking') }}</textarea>
                    </div>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary">Gửi</button>
                </div>
            </form>
        </div>

        <ul>
            <li>Khi có thông báo lỗi, hãy kiểm tra kỹ phần nhập liệu</li>
            <li>Ví dụ cú pháp đúng: VN123456789,VN987654321,</li>
            <li>Không có khoảng trắng giữa các dấu , (Ví dụ cú pháp có khoảng trắng sai: VN123456789, VN987654321,)</li>
        </ul>
       
    </div>
@endsection