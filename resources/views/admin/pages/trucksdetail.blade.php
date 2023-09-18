@extends('admin.dashboard')
@section('admin_content')
<div class="container row">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Start-End</th>
            <th scope="col">Lisence Spate</th>
            <th scope="col">Status</th>
            <th scope="col">Datetimes</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($get_all_truck as $truck)
                @php
                    $i = 1;
                @endphp
                <tr>
                    <th>{{$i}}</th>
                    <td>{{$truck->start_end}}</td>
                    <td>{{$truck->bks}}</td>
                    <td>{{$truck->name_status}}</td>
                    <td><a href="{{URL::to('truck-details/'.$truck->id_truck)}}"><i class="bi bi-eye-fill"></i></a></td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
          
          
        </tbody>
      </table>
</div>
@endsection