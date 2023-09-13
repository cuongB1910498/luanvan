@extends('staff.dashboard')
@section('staff-content')

<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Change password
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" role="form" method="post" action="{{URL::to('/staff/change-password')}}">
                {{ csrf_field() }}

                <?php
                    $msg_change_password = Session::get('msg_change_password');
                    if($msg_change_password){
                        echo $msg_change_password;
                        Session::put('msg_change_password',null);
                    }
                ?>

                <div class="form-group">
                    <label for="old_password" class="col-lg-2 col-sm-2 control-label">Old Password</label>
                    <div class="col-lg-10">
                        <input type="password" class="form-control" id="old_password" placeholder="Password" name="old_password">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="staff_password" class="col-lg-2 col-sm-2 control-label">Password</label>
                    <div class="col-lg-10">
                        <input type="password" class="form-control" id="staff_password" placeholder="Password" name="staff_password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="col-lg-2 col-sm-2 control-label">Confirm Password</label>
                    <div class="col-lg-10">
                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-danger">Change!</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>

</div>

@endsection