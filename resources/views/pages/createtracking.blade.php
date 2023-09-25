@extends('pages.dashboard')
@section('user_content')
    {{-- <div class="container"> --}}
    <?php
            $msg_create_tracking = Session::get('msg_create_tracking');
            if($msg_create_tracking){
        ?>
    <p style="color: red"><?php echo $msg_create_tracking; ?></p>

    <?php
            Session::put('msg_create_tracking', null);
            }
        ?>
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
                        <div class="form-group row mb-3">
                            <label for="address_sent" class="">Địa chỉ người gửi:</label>
                            <div class="col-sm-10 col-12">
                                <input type="text" class="form-control" id="address_sent" name="address_sent">
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
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="district_sent">Quận/Huyện/TX</label>
                                <div class="col-sm-10 col">
                                    {{-- <input type="text" class="form-control" id="district_sent" name="district_sent"> --}}
                                    <select name="district_sent" id="district_sent" class="form-select">
                                        <option value="" selected disabled>Chọn Huyện</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-sm-6 col-12 form-group row">
                                <label for="name_sent" class="">Tên người gửi:</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="name_sent" name="name_sent">
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="phone_sent">SDT:</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="phone_sent" name="phone_sent">
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
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="district_receive">Quận/Huyện/TX:</label>
                                <div class="col-sm-10 col">
                                    <select name="district_receive" id="district_receive" class="form-select">
                                        <option value="" selected disabled>Chọn Huyện</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-sm-6 col-12 form-group row">
                                <label for="name_receive" class="">Tên người nhận:</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="name_receive" name="name_receive">
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="phone_receive">SDT người nhận</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="phone_receive" name="phone_receive">
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
                        </div>
                    </div>
                    

                    <div class="col-sm-6 col-12 form-group row mb-3">
                        <label for="">Kích thước:</label>
                        <div class="col-sm-3 col">
                            <input type="text" class="form-control" id="" name="width" placeholder="dài">
                        </div>
                        <div class="col-sm-3 col">
                            <input type="text" class="form-control" id="" name="height" placeholder="rộng">
                        </div>
                        <div class="col-sm-3 col">
                            <input type="text" class="form-control" id="" name="depth" placeholder="cao">
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
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3 ">
                    <div class="col-sm-3 col-12 form-group row mb-3">
                        <label for="weight" class="mb-3">Trọng lượng:</label>
                        <div class="col-sm-10 col">
                            <input type="text" class="form-control" id="weight" name="weight" placeholder="(g)" oninput="cal_price()">
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
    <script>
        $(document).ready(function() {
            $('#province_sent').on('change', function() {
            var selectedValue = $(this).val();
            //alert(selectedValue);
            $.ajax({
                url: 'select-province',
                  method: 'GET',
                  data: {
                    selectedValue: selectedValue
                  },
                success: function(data) {
                    var district_sent =$('#district_sent');
                    district_sent.empty();
                    $.each(data, function(key, district) {
                        $('#district_sent').append($('<option>', {
                            value: district.id_district,
                            text: district.district_name
                        }));
                    });
                },
                error: function() {
                  alert('Đã có lỗi xảy ra.');
                }
              });
            });

            $('#province_receive').on('change', function() {
            var selectedValue = $(this).val();
            //alert(selectedValue);
            $.ajax({
                url: 'select-province',
                  method: 'GET',
                  data: {
                    selectedValue: selectedValue
                  },
                success: function(data) {
                    var district_sent =$('#district_receive');
                    district_sent.empty();
                    $.each(data, function(key, district) {
                        $('#district_receive').append($('<option>', {
                            value: district.id_district,
                            text: district.district_name
                        }));
                    });
                },
                error: function() {
                  alert('Đã có lỗi xảy ra.');
                }
              });
            });

            
            
        });
        function formatCurrency(number) {
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        }

        function cal_price(){
            var province_sent = document.getElementById("province_sent").value;
            var province_receive = document.getElementById("province_receive").value;
            var getinput = document.getElementById("weight").value;
            var get_extra_service = document.getElementById("id_extra_service").value;
            var split_es = get_extra_service.split('-');
            var extra_service = parseInt(split_es[0]);
            var gram = parseInt(getinput)
            if(province_receive == province_sent){
                //document.getElementById("result").textContent = province_receive+' - '+province_sent;
                if(gram <= 500){
                    price = 20000 + extra_service;
                    document.getElementById("result").textContent = formatCurrency(price);
                }else if(gram > 500 && gram <= 1000){
                    price = 25000 + extra_service;
                    document.getElementById("result").textContent = formatCurrency(price);
                }else if( gram > 1000 && gram <=3000){
                    
                    price = 30000 + extra_service;
                    document.getElementById("result").textContent = formatCurrency(price);
                }else if(gram > 3000){
                    price = 30000 + (gram - 3000)*15 + extra_service
                    document.getElementById("result").textContent = formatCurrency(price);
                }
                else{
                    document.getElementById("result").textContent = "Chưa nhập hoặc Lỗi nhập liệu";
                }
            }else{
                //document.getElementById("result").textContent = province_receive+province_sent;
                if(gram <= 500){
                    price =25000 + extra_service;
                    document.getElementById("result").textContent = formatCurrency(price);
                }else if(gram > 500 && gram <= 1000){
                    
                    price =30000 + extra_service;
                    document.getElementById("result").textContent = formatCurrency(price);
                }else if( gram > 1000 && gram <=3000){
                    
                    price =40000 + extra_service;
                    document.getElementById("result").textContent = formatCurrency(price);
                }else if(gram > 3000){
                    price =40000 + (gram - 3000)*15 + extra_service
                    document.getElementById("result").textContent = formatCurrency(price);
                }
                else{
                    document.getElementById("result").textContent = "Chưa nhập hoặc Lỗi nhập liệu";
                }
            }
            
        }
    </script>
@endsection
