@extends('staff.dashboard')
@section('staff-content')

<div class="container">
    <div class="card col-10 offset-sm-1">
        <h2 class="card-header">
            Thay đổi mật khẩu
        </h2>
        <div class="card-body">
            <div class="">
                <form class="form-horizontal" role="form" method="post" action="{{URL::to('/staff/change-password')}}">
                {{ csrf_field() }}

                <?php
                    $msg_change_password = Session::get('msg_change_password');
                    if($msg_change_password){
                        echo $msg_change_password;
                        Session::put('msg_change_password',null);
                    }
                ?>

                <div class="form-group row mb-3">
                    <label for="old_password" class="col-lg-2 col-sm-2 offset-sm-1">Mật khẩu cũ:</label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control" id="old_password" placeholder="Password" name="old_password">
                    </div>
                </div>
                
                <div class="form-group row mb-3">
                    <label for="staff_password" class="col-lg-2 col-sm-2 offset-sm-1">Mật khẩu mới:</label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control" id="staff_password" placeholder="Password" name="staff_password">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="confirm_password" class="col-lg-2 col-sm-2 offset-sm-1">Xác nhận mật khẩu mới:</label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-lg-offset-2 col-lg-8 offset-sm-1">
                        <button type="submit" class="btn btn-danger">Thay đổi !</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

</div>

@endsection