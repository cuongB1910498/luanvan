@extends('admin.dashboard')
@section('admin_content')
<div class="container row">
    <h2>Truck Log</h2>
    <div class="row">
        <div class="col-sm-3">
            <select name="" id="" class="form-select">                
                <option value=""> {{$now->subDay(7)->format('d-m-Y')}}</option>
                <option value=""> {{$now->subDay(6)->format('d-m-Y')}}</option>
                <option value=""> {{$now->subDay(5)->format('d-m-Y')}}</option>
                <option value=""> {{$now->subDay(4)->format('d-m-Y')}}</option>
                <option value=""> {{$now->subDay(3)->format('d-m-Y')}}</option>
                <option value=""> {{$now->subDay(2)->format('d-m-Y')}}</option>
                <option value=""> {{$now->subDay(1)->format('d-m-Y')}}</option>
                <option value="" selected>Today - {{$now->format('d-m-Y')}}</option>
            </select>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Staff Name</th>
            <th scope="col">Station name</th>
            <th scope="col">Note</th>
            <th scope="col">Datetimes</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($get_truck_log as $log)
                @php
                    $i = 1;
                @endphp
                <tr>
                    <th></th>
                    <td>{{$log->staff_name}}</td>
                    <td>{{$log->station_name}}</td>
                    <td>{{$log->note}}</td>
                    <td>{{$now->format('d-m-Y')}}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
          
          
        </tbody>
      </table>
</div>
@endsection