@extends('staff.dashboard')
@section('staff-content')

<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Staff Profile
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" role="form" method="post" action="{{ URL::to('/staff/user-change')}}">
                    {{ csrf_field() }}
                    <?php
                        $msg_update_info = Session::get('msg_update_info');
                        if($msg_update_info){
                    ?>
                    <div class="error text-center" style="color: red">
                        <?php
                            echo $msg_update_info;
                        ?>
                    </div>
                    <?php
                        Session::put('msg_update_info', null);
                        }
                    ?>
                
                    <div class="form-group">
                        <label for="staff_name" class="col-lg-2 col-sm-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_name" placeholder="staff_name" name="staff_name" value="{{ $staff_info->staff_name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="staff_phone" class="col-lg-2 col-sm-2 control-label">Phone</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_phone" placeholder="staff_phone" name="staff_phone" value="{{ $staff_info->staff_phone}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Staff_email" class="col-lg-2 col-sm-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="email" class="form-control" id="Staff_email" placeholder="Staff_email" name="Staff_email" value="{{ $staff_info->staff_email}}">
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