@extends('admin.dashboard')
@section('admin_content')
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            ADD NEW STATION
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" role="form" method="post" action={{URL::to('/add-station-process')}}>
                    {{ csrf_field() }}
                <div class="form-group text-center">
                    <?php
                        $msg_add_station = Session::get('msg_add_station');
                        if($msg_add_station){
                            echo $msg_add_station;
                            Session::put('msg_add_station', null);
                        }
                    ?>
                </div>

                <div class="form-group">
                    <label for="station_name" class="col-lg-2 col-sm-2 control-label">Station Name</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="station_name" name="station_name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="col-lg-2 col-sm-2 control-label">Address</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_district" class="col-lg-2 col-sm-2 control-label">District</label>
                    <div class="col-lg-10">
                        <select name="id_district" id="id_district" class="form-control">
                            @foreach ($district as $row)
                                <option value="{{ $row->id_district }}">{{ $row->province_name.' - '.$row->district_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="is_main" class="col-lg-2 col-sm-2 control-label">Is Main Station ?</label>
                    <div class="col-lg-10"> 
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="is_main" id="is_main" value="1">
                            </label>
                        </div>
                    </div>
                </div>

                

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-danger">Tạo!</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection