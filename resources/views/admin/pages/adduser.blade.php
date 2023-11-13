@extends('admin.dashboard')
@section('admin_content')
    <div class="container">
        @if (Session('success'))
            <div class="alert alert-success">{{Session('success')}}</div>
        @endif

        @if (Session('error'))
            <div class="alert alert-danger">{{Session('error')}}</div>
        @endif
        <div class="card">
            <header class="card-header">
                Add New Staff
            </header>
            <div class="card-body col-sm-10 offset-sm-1">

                <form role="form" method="post" action="{{ URL::to('user-add-process') }}">
                    {{ csrf_field() }}
                    <div class="form-group row mb-3">
                        <label for="username" class="col-lg-2 col-sm-2 control-label">TK Nhân viên:</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="username" placeholder=""
                                name="username">
                                @error('username')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="name" class="col-lg-2 col-sm-2 control-label">Họ tên:</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="name" placeholder=""
                                name="name">
                                @error('name')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="phone" class="col-lg-2 col-sm-2 control-label">SDT:</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="phone" placeholder=""
                                name="phone">
                                @error('phone')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="email" class="col-lg-2 col-sm-2 control-label">Email:</label>
                        <div class="col-lg-10">
                            <input type="email" class="form-control" id="email" placeholder=""
                                name="email">
                                @error('email')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="station" class="col-lg-2 col-sm-2 control-label">Trạm công tác:</label>
                        <div class="col-lg-10">
                            <select name="station" id="station" class="form-select">
                                @foreach ($id_station as $rows)
                                    <option value="{{ $rows->id_station }}">{{ $rows->station_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="posision" class="col-lg-2 col-sm-2 control-label">Chức vụ:</label>
                        <div class="col-lg-10">
                            <select name="posision" id="posision" class="form-select">
                                @foreach ($get_posision as $row)
                                    <option value="{{ $row->id_posision }}"> {{ $row->posision_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-danger">Create!</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
