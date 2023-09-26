@extends('pages.dashboard')
@section('user_content')
    <div class="container row">
        @if (Session::get('success'))
            <div class="col-sm-6 col-12 offset-lg-3 alert bg-success">{{Session::get('success')}}</div>
        @endif

        @if (Session::get('error'))
            <div class="col-sm-6 col-12 offset-lg-3 alert bg-warning">{{Session::get('error')}}</div>
        @endif
            
        <div class="card col-sm-6 col-12 offset-lg-3">
            <div class="card-header">
                <h2 class="mb-3">Import Tracking By Excel File</h2>
            </div>
            <div class="card-body">
                <form action="{{URL::to('/import-csv')}}" method="post" class="row" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row from-group mb-3">
                        <label for="" class="">chọn file excel</label>
                        <div class="">
                            <input type="file" class="form-control" name="file" accept=".xlsx">
                        </div>
                    </div>
        
                    <div class="row form-group mb-3">
                        <button class="btn btn-primary col-sm-2 col-3 offset-lg-3">submit</button>
                    </div>
                </form>
            </div>
        </div>
          
    </div>
@endsection