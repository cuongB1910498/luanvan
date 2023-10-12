@extends('pages.dashboard')
@section('user_content')
    <div class="container">
        <div class="row">
            <div class="card col-6 offset-lg-3">
                @if (Session('success'))
                    <div class="alert alert-success">{{Session('success')}}</div>
                @endif
                <div class="card-header">
                    <h2>Thông tin tài Khoản</h2>
                </div>

                <form action="{{URL::to('/change-profile')}}" method="post">   
                    @csrf            
                    <div class="card-body">
                        <div class="row form-group mb-3">
                            <label for="lastname">Họ:</label>
                            <div class="col">
                                <input type="text" name="lastname" id="lastname" class="form-control" value="{{$profile->lastname}}">
                                @error('lastname')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <label for="firstname">Tên:</label>
                            <div class="col">
                                <input type="text" name="firstname" id="firstname" class="form-control" value="{{$profile->firstname}}">
                                @error('firstname')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <label for="phone">Điện thoại:</label>
                            <div class="col">
                                <input type="text" name="phone" id="phone" class="form-control" value="{{$profile->phone}}">
                                @error('phone')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <label for="email">Email:</label>
                            <div class="col">
                                <input type="text" name="email" id="email" disabled class="form-control" value="{{$profile->email}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary col-sm-3 offset-sm-2 offset-3">Chỉnh sửa</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection