@extends('pages.dashboard')
@section('user_content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Tra cứu đơn hàng</h2>
            </div>

            <div class="card-body">
                 <form id="tracking-form"> {{--action="{{URL::to('/process-tracking')}}" method="post">  --}}
                    {{ csrf_field() }}
                    <div class="form-group row mb-3">
                        <label for="tracking" class="row">Nhập mã đơn cần tra cứu:</label>
                        <div class="row">
                            <textarea class="form-control" name="tracking" id="tracking" class="col-10 offset-2"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <p>Ghi chú: nếu nhiều đơn thì các đơn cách nhau bởi dấu ,</p>
                        <p>Ví dụ: VN121212132,VN882836623</p>
                    </div>

                    <div class="row mb-3">
                        <button class="col-1 offset-1 btn btn-primary">Tra cứu!</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="results"></div>

    </div>

@endsection