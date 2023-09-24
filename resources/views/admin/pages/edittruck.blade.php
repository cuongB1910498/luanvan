@extends('admin.dashboard')
@section('admin_content')
<div class="container row">
    <div class="row add_truck mb-3">
        <div class="card row">
            <div class="card-header">
                <h2 class="text-center mb-3">Add New Truck</h2>
            </div>
            <div class="card-body">
                <form action="{{URL::to('/update-truck-process/'.$get_truck->id_truck)}}" method="post" class="row">
                    {{ csrf_field() }}
                    <div class="row form-group mb-3">
                        <label for="bks" class="col-lg-2 offset-lg-1">License plates</label>
                        <div class="col-lg-8">
                            <input type="text" id="bks" name="bks" class="form-control" value="{{$get_truck->bks}}">
                        </div>
                    </div>


                    <div class="row form-group mb-3">
                        <label for="start_point" class="col-lg-2 offset-lg-1">Start Point</label>
                        <div class="col-lg-8">
                            <input type="text" id="start_point" name="start_point" class="form-control" value="{{$get_truck->start_point}}">
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        <label for="end_point" class="col-lg-2 offset-lg-1">End Point</label>
                        <div class="col-lg-8">
                            <input type="text" id="end_point" name="end_point" class="form-control" value="{{$get_truck->end_point}}">
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        <label for="id_staff" class="col-lg-2 offset-lg-1">Driver</label>
                        <div class="col-lg-8">
                            <select name="id_staff" id="id_staff" class="form-select">
                                    <option value="none">None</option>
                                @foreach ($get_driver as $driver)
                                    @if ($driver->id_staff == $get_truck->id_staff)
                                        <option value="{{$driver->id_staff}}" selected>{{$driver->staff_name}}</option>
                                    @else
                                        <option value="{{$driver->id_staff}}" >{{$driver->staff_name}}</option>
                                    @endif
                                @endforeach
                                
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <button class="col-lg-1 offset-lg-4 btn btn-primary btn-default me-2">Change!</button>
                        <a  href="{{URL::to('/detete-truck/'.$get_truck->id_truck)}}" class="col-lg-1 btn btn-danger btn-default" onclick="return confirm('Are you sure to Delete Truck?!')">Delete</a>
                    </div>
                </form>
            </div>
        </div>
        
        
    </div>
</div>
@endsection