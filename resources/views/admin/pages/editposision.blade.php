@extends('admin.dashboard')
@section('admin_content')

<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            UPDATE POSISION
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" role="form" method="post" action={{URL::to('/update-posision/'.$edit_posision->id_posision)}}>
                    {{ csrf_field() }}
                <div class="form-group text-center msg_posision">
                    <?php
                        $update_error = Session::get('update_error');
                        if($update_error){
                            echo $update_error;
                            Session::put('update_error', null);
                        }
                    ?>
                </div>

                <div class="form-group">
                    <label for="posision_name" class="col-lg-2 col-sm-2 control-label">Posision name</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="posision_name" name="posision_name" value="{{ $edit_posision->posision_name }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="lvl_salary" class="col-lg-2 col-sm-2 control-label">Level Salary</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="lvl_salary" name="lvl_salary" value="{{ $edit_posision->lvl_salary }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-danger">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>

</div>
    
@endsection