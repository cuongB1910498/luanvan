@extends('admin.dashboard')
@section('admin_content')
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Add New User
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" role="form" method="post" action="{{ URL::to('user-add-process')}}">
                    {{ csrf_field() }}
                    <?php
                        $msg_adduser = Session::get('msg_adduser');
                        if($msg_adduser){
                    ?>
                    <div class="error text-center" style="color: red">
                        <?php
                            echo $msg_adduser;
                        ?>
                    </div>
                    <?php
                        Session::put('msg_adduser', null);
                        }
                    ?>
                    <div class="form-group">
                        <label for="staff_username" class="col-lg-2 col-sm-2 control-label">Username</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_username" placeholder="staff_username" name="staff_username">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="staff_name" class="col-lg-2 col-sm-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_name" placeholder="staff_name" name="staff_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="staff_phone" class="col-lg-2 col-sm-2 control-label">Phone</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_phone" placeholder="staff_phone" name="staff_phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Staff_email" class="col-lg-2 col-sm-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="email" class="form-control" id="Staff_email" placeholder="Staff_email" name="Staff_email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Staffpass" class="col-lg-2 col-sm-2 control-label">Staff Posision</label>
                        <div class="col-lg-10">
                            <select name="id_posision" id="id_posision" class="form-control">
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
    </section>

</div>
@endsection