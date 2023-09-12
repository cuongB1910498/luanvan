@extends('admin.dashboard')
@section('admin_content')
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Add New Staff
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" role="form" method="post" action="{{ URL::to('/edit-staff-process/'.$get_staff->id_staff)}}">
                    {{ csrf_field() }}
                   
                    <div class="form-group">
                        <label for="staff_name" class="col-lg-2 col-sm-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_name" placeholder="staff_name" name="staff_name" value=" {{$get_staff->staff_name}} ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="staff_phone" class="col-lg-2 col-sm-2 control-label">Phone</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="staff_phone" placeholder="staff_phone" name="staff_phone" value=" {{$get_staff->staff_phone}} ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Staff_email" class="col-lg-2 col-sm-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="email" class="form-control" id="Staff_email" placeholder="Staff_email" name="staff_email" value=" {{$get_staff->staff_email}} ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_station" class="col-lg-2 col-sm-2 control-label">Station</label>
                        <div class="col-lg-10">
                            <select name="id_station" id="id_station" class="form-control">
                                @foreach ($get_station as $rows)
                                    @if ($rows->id_station == $get_staff->id_station)
                                        <option value="{{ $rows->id_station }}" selected>
                                            {{ $rows->station_name }}
                                        </option>
                                    @else 
                                        <option value="{{ $rows->id_station }}">
                                            {{ $rows->station_name }}
                                        </option>
                                    @endif
                                    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Staffpass" class="col-lg-2 col-sm-2 control-label">Staff Posision</label>
                        <div class="col-lg-10">
                            <select name="id_posision" id="id_posision" class="form-control">
                                @foreach ($get_posision as $row)
                                    @if ($row->id_posision == $get_staff->id_posision)
                                        <option value="{{ $row->id_posision}}" selected> {{ $row->posision_name }} </option>
                                    @else
                                        <option value="{{ $row->id_posision}}"> {{ $row->posision_name }} </option>
                                    @endif
                                @endforeach
                            </select>
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