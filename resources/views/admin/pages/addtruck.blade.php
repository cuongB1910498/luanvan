@extends('admin.dashboard')
@section('admin_content')
    @if(Session::get('success'))
        <div class="alert alert-success">
            {{ session::get('success') }}
        </div>
    @endif
    
    @if(Session::get('delete_success'))
        <div class="alert alert-danger">
            {{ session::get('delete_success') }}
        </div>
    @endif
    <div class="container row">
        <div class="row add_truck mb-3">
            <div class="card row">
                <div class="card-header">
                    <h2 class="text-center mb-3">Add New Truck</h2>
                </div>
                <div class="card-body">
                    <form action="{{URL::to('/add-truck-process')}}" method="post" class="row">
                        {{ csrf_field() }}
                        <div class="row form-group mb-3">
                            <label for="bks" class="col-lg-2 offset-lg-1">License plates</label>
                            <div class="col-lg-8">
                                <input type="text" id="bks" name="bks" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <label for="start_end" class="col-lg-2 offset-lg-1">Start - End</label>
                            <div class="col-lg-8">
                                <input type="text" id="start_end" name="start_end" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <button class="col-lg-1 offset-lg-4 btn btn-primary btn-default">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            
            
        </div>

        <div class="row list_truck mt-3">
            <h2>List Truck</h2>
            <table class="table table-striped" id="myTable">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">License Plate</th>
                    <th scope="col">Start - End</th>
                    <th scope="col">Handle</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($get_all_truck as $truck)
                        @php
                            $i = 1;
                        @endphp
                        <tr>
                            <th>{{ $i }}</th>
                            <td>{{ $truck->bks }}</td>
                            <td>{{ $truck->start_end }}</td>
                            <td><a href="{{URL::to('/edit-truck/'.$truck->id_truck)}}"><i class="bi bi-pen-fill"></i></a></td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    
                </tbody>
              </table>
        </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    
@endsection