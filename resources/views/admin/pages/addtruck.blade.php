@extends('admin.dashboard')
@section('admin_content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ session::get('success') }}
        </div>
    @endif

    @if (Session::get('delete_success'))
        <div class="alert alert-danger">
            {{ session::get('delete_success') }}
        </div>
    @endif
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-3">Thêm xe tải mới</h2>
            </div>
            <div class="card-body">
                <form action="{{ URL::to('/add-truck-process') }}" method="post" class="row">
                    {{ csrf_field() }}
                    <div class="row form-group mb-3">
                        <label for="bks" class="col-lg-2 offset-lg-1">Biển Kiểm Soát</label>
                        <div class="col-lg-8">
                            <input type="text" id="bks" name="bks" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        <label for="start_point" class="col-lg-2 offset-lg-1">Điểm đầu</label>
                        <div class="col-lg-8">
                            <input type="text" id="start_point" name="start_point" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        <label for="end_point" class="col-lg-2 offset-lg-1">Điểm cuối</label>
                        <div class="col-lg-8">
                            <input type="text" id="end_point" name="end_point" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        <label for="id_staff" class="col-lg-2 offset-lg-1">Chọn tài xế</label>
                        <div class="col-lg-8">
                            <select name="id_staff" id="id_staff" class="form-select">
                                <option value="none">None</option>
                                @foreach ($get_driver as $driver)
                                    <option value="{{ $driver->id_staff }}">{{ $driver->staff_name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <button class="col-lg-1 offset-lg-4 btn btn-primary btn-default">Thêm</button>
                    </div>
                </form>
            </div>
        </div>




        <div class="row list_truck mt-3">
            <h2>List Truck</h2>
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">BKS</th>
                        <th scope="col">Start - End</th>
                        <th scope="col">QL</th>
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
                            <td>{{ $truck->start_point . ' - ' . $truck->end_point }}</td>
                            <td><a href="{{ URL::to('/edit-truck/' . $truck->id_truck) }}"><i class="bi bi-pen-fill"></i></a>
                            </td>
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
