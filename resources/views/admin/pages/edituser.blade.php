@extends('admin.dashboard')
@section('admin_content')
    <div class="container">
        <div class="card">
            <header class="card-header">
                Chỉnh sửa nhân viên
            </header>
            <div class="card-body col-sm-10 offset-sm-1">

                <form role="form" method="post" action="{{ URL::to('/edit-user/'.$staff->id_staff) }}">
                    {{ csrf_field() }}
                    <div class="form-group row mb-3">
                        <label for="staff_username" class="col-lg-2 col-sm-2 control-label">TK nhân viên</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_username" placeholder=""
                                name="username" value="{{$staff->staff_username}}">
                                @error('username')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="staff_name" class="col-lg-2 col-sm-2 control-label">Họ tên</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_name" placeholder=""
                                name="name" value="{{$staff->staff_name}}">
                                @error('name')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="staff_phone" class="col-lg-2 col-sm-2 control-label">SDT</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_phone" placeholder=""
                                name="phone" value="{{$staff->staff_phone}}">
                                @error('phone')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Staff_email" class="col-lg-2 col-sm-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="email" class="form-control" id="Staff_email" placeholder=""
                                name="email" value="{{$staff->staff_email}}">
                                @error('email')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="station" class="col-lg-2 col-sm-2 control-label">Trạm công tác</label>
                        <div class="col-lg-10">
                            <select name="station" id="station" class="form-select">
                                @foreach ($get_station as $station)
                                    @if ($station->id_station == $staff->id_station)
                                    <option value="{{ $station->id_station }}" selected>{{ $station->station_name }}</option>
                                    @else
                                    <option value="{{ $station->id_station }}">{{ $station->station_name }}</option> 
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="posision" class="col-lg-2 col-sm-2 control-label">Chức vụ</label>
                        <div class="col-lg-10">
                            <select name="posision" id="posision" class="form-select">
                                @foreach ($get_posision as $row)
                                    @if($row->id_posision == $staff->id_posision)
                                    <option value="{{ $row->id_posision }}" selected> {{ $row->posision_name }}</option>
                                    @else 
                                    <option value="{{ $row->id_posision }}" selected> {{ $row->posision_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-warning">Thay đổi!</button>
                            <a href="{{URL::to('/delete-user/'.$staff->id_staff)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắt muốn xóa người dùng này ?!')">Xóa nhân viên này!</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
