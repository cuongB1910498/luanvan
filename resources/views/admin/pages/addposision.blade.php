@extends('admin.dashboard')
@section('admin_content')

<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            ADD NEW POSISION
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" role="form" method="post" action={{URL::to('/possison-process')}}>
                    {{ csrf_field() }}
                <div class="form-group text-center msg_posision">
                    <?php
                        $msg_posision = Session::get('msg_posision');
                        if($msg_posision){
                            echo $msg_posision;
                            Session::put('msg_posision', null);
                        }
                    ?>
                </div>

                <div class="form-group">
                    <label for="posision_name" class="col-lg-2 col-sm-2 control-label">Posision name</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="posision_name" name="posision_name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="lvl_salary" class="col-lg-2 col-sm-2 control-label">Level Salary</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="lvl_salary" name="lvl_salary">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>

</div>
    
@endsection