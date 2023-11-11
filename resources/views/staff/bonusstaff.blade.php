@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                @if(Session('success'))
                    <div class="alert alert-success">{{Session('success')}}</div>
                @endif

                @error('error')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                <div class="card">
                    <div class="card-header">
                        Thưởng nhân viên
                    </div>
                    <div class="card-body">
                        <form action="{{URL::to('/staff/bonus-process')}}" method="post" class="row">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="staff">Chọn nhân viên:</label>
                                <div class="col">
                                    <select name="staff" id="staff" class="form-select">
                                        <option selected disabled>---Chọn nhân viên---</option>
                                        @foreach ($get_staff as $row)
                                            <option value="{{$row->id_staff}}">{{$row->staff_name.' | '. $row->posision_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('staff')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="prize_money">Mức thưởng:</label>
                                <div class="col">
                                    <div class="col">
                                        <input type="text" name="prize_money" id="prize_money" class="form-control">
                                        @error('prize_money')
                                            <label for="" class="text-danger">{{$message}}</label>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="reason">Nội dung thưởng:</label>
                                <div class="col">
                                    <div class="col">
                                        <input type="text" name="reason" id="reason" class="form-control">
                                        @error('reason')
                                            <label for="" class="text-danger">{{$message}}</label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Xác nhận</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection