@extends('pages.dashboard')
@section('user_content')
    <div class="container row">
        @if (Session('success'))
            <div class="alert alert-success">{{Session('success')}}</div>
        @endif
        @if (Session('error'))
            <div class="alert alert-danger">{{Session('error')}}</div>
        @endif
        <div class="card col-6 offset-3">
            <div class="card-header">
                <h1>Thêm địa chỉ mới</h1>
            </div>
            <div class="card-body">
                <form action="{{URL::to('/add-address-process')}}" method="post">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="address_name">Tên địa chỉ: </label>
                        <div class="col">
                            <input type="text" value="Địa chỉ của tôi!" placeholder="Tên địa chỉ để phân biệt các địa chỉ với nhau" class="form-control" name="address_name" id="address_name">
                            @error('address_name')
                                <label class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="address_sent">Địa chỉ (Càng cụ thể càng tốt): </label>
                        <div class="col">
                            <input type="text" placeholder="số nhà, tên đường, khu phố, tổ, ấp, xóm, khu vực" class="form-control" name="address_sent" id="address_sent">
                            @error('address_sent')
                                <label class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="province_sent">Chọn Tỉnh: </label>
                        <div class="col">
                            <select name="province_sent" id="province_sent" class="form-select">
                                <option value="" disabled selected>---Tỉnh/TP---</option>
                                @foreach ($get_province as $row)
                                    <option value="{{$row->id_province}}">{{$row->province_name}}</option>
                                @endforeach
                            </select>
                            @error('province_sent')
                                <label class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="district_sent">Chọn Huyện: </label>
                        <div class="col">
                            <select name="district_sent" id="district_sent" class="form-select">
                                <option value="" disabled selected>---Quận/Huyện/Thị Xã---</option>
                            </select>
                            @error('district_sent')
                                <label class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1">
                            <button type="submit" class="btn btn-primary">Thêm!</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('public/frontend/js/select_district.js')}}"></script>
@endsection