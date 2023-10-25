@extends('pages.dashboard')
@section('user_content')
    {{-- <div class="container"> --}}
    @if (Session('success'))
        <div class="alert alert-success">{{Session('success')}}</div>
    @endif
    <div class="card">
        <div class="card-header text-center bg-info">
            <h2 style="color: white">Tạo đơn Vận Chuyển</h2>
        </div>
        <div class="card-body">

            <form role="form" method="post" action="{{ URL::to('/creating-process') }}">
                <div class="row mb-3">
                    {{ csrf_field() }}
                    {{-- bên trái --}}
                    <div class="col-sm-6 col-12 bg-light">
                        @if ($get_address->isEmpty())
                        <div class="form-group row mb-3">
                            <label for="address_sent" class="">Địa chỉ người gửi:</label>
                            <div class="col-sm-10 col-12">
                                <input type="text" class="form-control" id="address_sent" name="address_sent">
                                @error('address_sent')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-sm-6 col-12 form-group row">
                                <label for="province_sent" class="">Tỉnh/TP:</label>
                                <div class="col-sm-10 col">
                                    {{-- <input type="text" class="form-control" id="province_sent" name="province_sent"> --}}
                                    <select name="province_sent" id="province_sent" class="form-select" onchange="cal_price()">
                                        <option value="" selected disabled>Chọn Tỉnh</option>
                                        @foreach ($get_province as $province)
                                            <option value="{{$province->id_province}}">{{ $province->province_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('province_sent')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="district_sent">Quận/Huyện/TX</label>
                                <div class="col-sm-10 col">
                                    {{-- <input type="text" class="form-control" id="district_sent" name="district_sent"> --}}
                                    <select name="district_sent" id="district_sent" class="form-select">
                                        <option value="" selected disabled>Chọn Huyện</option>

                                    </select>
                                    @error('district_sent')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="form-group row mb-3">
                            <label for="id_address">Chọn địa chỉ:</label>
                            <div class="col-sm-10 col">
                            <select name="id_address" id="id_address" class="form-select" onchange="cal_price()">
                                <option value="" disabled selected>---chọn địa chỉ---</option>
                                @foreach ($get_address as $row)
                                    <option value="{{$row->id_address}}">{{$row->address_sent.', '.$row->district_name.', '.$row->province_name}}</option>
                                @endforeach
                            </select>
                            @error('id_address')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                            </div>
                        </div>
                        @endif

                        <div class="form-group row mb-3">
                            <div class="col-sm-6 col-12 form-group row">
                                <label for="name_sent" class="">Tên người gửi:</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="name_sent" name="name_sent" @if ($get_user)
                                        value="{{$get_user->lastname.' '.$get_user->firstname}}"
                                    @endif>
                                    @error('name_sent')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="phone_sent">SDT:</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="phone_sent" name="phone_sent" @if ($get_user)
                                    value="{{$get_user->phone}}"
                                @endif>
                                    @error('phone_sent')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                    </div>

                    {{-- bên phải --}}
                    <div class="col-sm-6 col-12 bg-light">
                        <div class="form-group row mb-3">
                            <label for="address_receive" class="">Địa chỉ người nhận:</label>
                            <div class="col-sm-10 col-12">
                                <input type="text" class="form-control" id="address_receive" name="address_receive">
                                @error('address_receive')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-sm-6 col-12 form-group row">
                                <label for="province_receive" class="">Tỉnh/TP:</label>
                                <div class="col-sm-10 col">
                                   <select name="province_receive" id="province_receive" class="form-select" onchange="cal_price()">
                                        <option value="" selected disabled>Chọn Tỉnh</option>
                                        @foreach ($get_province as $province)
                                            <option value="{{$province->id_province}}">{{ $province->province_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('province_receive')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="district_receive">Quận/Huyện/TX:</label>
                                <div class="col-sm-10 col">
                                    <select name="district_receive" id="district_receive" class="form-select">
                                        <option value="" selected disabled>Chọn Huyện</option>

                                    </select>
                                    @error('district_receive')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-sm-6 col-12 form-group row">
                                <label for="name_receive" class="">Tên người nhận:</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="name_receive" name="name_receive">
                                    @error('name_receive')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="phone_receive">SDT người nhận</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="phone_receive" name="phone_receive">
                                    @error('phone_receive')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row text-center">
                    <h4>Thông tin gói hàng</h4>
                </div>

                <div class="row form-group mb-3">
                    <label for="describe_tracking" class="offset-lg-1">Mô tả: </label>
                    <div class="col-lg-10 col offset-lg-1">
                        <textarea name="describe_tracking" id="describe_tracking" rows="5" class="form-control"></textarea>
                        @error('describe_tracking')
                            <label for="" class="text-danger">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-3 col-12 form-group row">
                        <label for="type_sending" class="">Loại ký gửi:</label>
                        <div class="col-sm-10 col">
                            <select class="form-select" id="type_sending" name="type_sending">
                                <option value="fast" selected>Nhanh</option>
                                <option value="eco">Tiết kiệm</option>
                            </select>
                            @error('type_sending')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    

                    <div class="col-sm-6 col-12 form-group row mb-3">
                        <label for="">Kích thước:</label>
                        <div class="col-sm-3 col">
                            <input type="text" class="form-control" id="" name="width" placeholder="dài">
                            @error('width')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-sm-3 col">
                            <input type="text" class="form-control" id="" name="height" placeholder="rộng">
                            @error('height')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-sm-3 col">
                            <input type="text" class="form-control" id="" name="depth" placeholder="cao">
                            @error('depth')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <label for="id_extra_service">Loại hàng hóa:</label>
                        <div class="col">
                            <select name="id_extra_service" id="id_extra_service" class="form-select" onchange="cal_price()">
                                @foreach ($get_service as $es)
                                    <option value="{{$es->es_price.'-'.$es->id_extra_service}}">{{$es->es_name.' +'.$es->es_price}}</option>
                                @endforeach
                                
                                
                            </select>
                            @error('id_extra_service')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3 ">
                    <div class="col-sm-3 col-12 form-group row mb-3">
                        <label for="weight" class="mb-3">Trọng lượng:</label>
                        <div class="col-sm-10 col">
                            <input type="text" class="form-control" id="weight" name="weight" placeholder="(g)" oninput="cal_price()">
                            @error('weight')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6 row">
                        <p class="mb-3">Tạm tính:</p>
                        <p id="result"></p>
                    </div>

                    <div class="col-sm-3 row form-group">
                        <label for="cod">Thu hộ:</label>
                        <div class="col-sm-10 col">
                            <input type="text" id="cod" name="cod" class="form-control">
                            @error('cod')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                </div>
                

                <div class="form-group text-center">
                    <button class="btn btn-primary">Tạo đơn</button>
                </div>
            </form>

        </div>

        
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('public/frontend/js/select_district.js')}}"></script>
@endsection
