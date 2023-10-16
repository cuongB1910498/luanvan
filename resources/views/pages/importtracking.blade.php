@extends('pages.dashboard')
@section('user_content')
    <div class="container">
        @if (Session::get('success'))
            <div class="alert bg-success text-light">{{Session::get('success')}}</div>
        @endif

        @if (Session::get('error'))
            <div class="alert bg-warning text-light">{{Session::get('error')}}</div>
        @endif
            
        <div class="card">
            <div class="card-header bg-info">
                <h2 class="mb-3 text-center">Tạo Nhiều Đơn bằng File Excel</h2>
            </div>
            <div class="card-body">
                <form action="{{URL::to('/import-csv')}}" method="post" class="row" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <h4>Địa chỉ lấy hàng:</h4>
                    <div class="row form-group mb-3">
                        <div class="col-sm-6 col-12">
                            <label for="address_sent">Địa chỉ người gửi:</label>
                            <div class="col">
                                <input type="text" name="address_sent" id="address_sent" class="form-control">
                                @error('address_sent')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-12 row">
                            <div class="col">
                                <label for="province_sent">Tỉnh/TP: </label>
                                <div class="col">
                                    <select name="province_sent" id="province_sent" class="form-select">
                                        <option value="" disabled selected>-----Tỉnh/TP------</option>
                                        @foreach ($get_province as $province)
                                            <option value="{{$province->id_province}}">{{$province->province_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('province_sent')
                                        <label class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                                
                            </div>

                            <div class="col">
                                <label for="district_sent">Quận/Huyện/Thị Xã: </label>
                                <div class="col">
                                    <select name="district_sent" id="district_sent" class="form-select">
                                        <option value="" selected>-----Quận/Huyện/Thị Xã------</option>
                                    </select>
                                    @error('district_sent')
                                        <label class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="row mb-3 mt-3">
                        <div class="col-sm-6 col-12">
                            <label for="name_sent">Họ tên người gửi:</label>
                            <div class="col">
                                <input type="text"name="name_sent" id="name_sent" class="form-control">
                                @error('name_sent')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <label for="phone_sent">SDT người gửi:</label>
                            <div class="col">
                                <input type="text"name="phone_sent" id="phone_sent" class="form-control">
                                @error('phone_sent')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row from-group mb-3 mt-3">
                        <div class="col-6 offset-sm-3">
                            <label for="" class="">chọn file excel:</label>
                            <div class="">
                                <input type="file" class="form-control mb-2" name="file" accept=".xlsx">
                                @error('file')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                                <p>Tải file excel mấu tại <a href="https://docs.google.com/spreadsheets/d/1IumO9HSz_tGz8bxZLTgrTwiwJ2prebZ9/edit?usp=sharing&ouid=115615661134750500040&rtpof=true&sd=true" target="_blank">ĐÂY</a></p>
                            </div>
                        </div>
                    </div>
        
                    <div class="row form-group mb-3">
                        <button class="btn btn-primary col-1">Gửi</button>
                    </div>
                </form>
            </div>
        </div>   
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('public/frontend/js/select_district.js')}}"></script>
@endsection