@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        @if (Session('success'))
            <div class="alert alert-success">{{Session('success')}}</div>
        @endif
        @if (Session('error'))
            <div class="alert alert-danger">{{Session('error')}}</div>
        @endif
        <h3 class="mb-4 mt-3">Nhập vào chuyển đi</h3>
        <form action="{{URL::to('/staff/process-add-bag')}}" method="post" class="col-8 offset-2">
            @csrf
            <div class="form-group row mb-3">
                <label for="id_tracking" class="col-1">Scan: </label>
                <div class="col-8">
                    <textarea name="id_tracking" id="id_tracking" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="col"><button class="btn btn-primary">Gửi</button></div>
            </div>
        </form>
    </div>
@endsection