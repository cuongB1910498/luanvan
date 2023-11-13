@extends('admin.dashboard')
@section('admin_content')

<div class="container">
    <div class="col-10 offset-1 card">
        <header class="card-header">
            THÊM CHỨC VỤ MỚI
        </header>
        <div class="card-body">
            <div class="row">
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

                <div class="form-group row mb-3">
                    <label for="posision_name" class="col-sm-2 control-label px-3 offset-sm-1">Tên chức vụ:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="posision_name" name="posision_name">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="lvl_salary" class="col-sm-2 control-label ps-3 offset-sm-1">Bật lương</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="lvl_salary" name="lvl_salary">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-offset-2 col-sm-10 offset-sm-1">
                        <button type="submit" class="btn btn-danger">Thêm!</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>
    
@endsection