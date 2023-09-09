@extends('pages.dashboard')
@section('user_content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <div class="container"> --}}
        <?php
            $msg_create_tracking = Session::get('msg_create_tracking');
            if($msg_create_tracking){
        ?>
        <p style="color: red"><?php echo $msg_create_tracking ?></p>

        <?php
            Session::put('msg_create_tracking', null);
            }
        ?>
        {{-- <h1 class="text-center">Tạo đơn hàng</h1> --}}
        {{-- <form action="" method="post" enctype="multipart/form-data">
            
            <div class="row mb-3">
                {{-- bên trái --}}
                {{-- <div class="col">
                    <div class="row mb-3">
                        Địa chỉ bên gửi:
                    </div>
                    <div class="row mb-3">
                        <input type="text" class="col-8" name="address_sent">
                    </div> --}}

                    {{-- tỉnh/huyện --}}
                    {{-- <div class="row mb-3">
                        <div class="col-4">
                            <div class="row">
                                Tỉnh/Thành Phố 
                            </div>
            
                            <div class="row">
                                <input type="text" class="col-10" name="province_sent">
                            </div>
                        </div>
    
                        <div class="col-4">
                            <div class="row">
                                Quận/Huyện/Thị xã 
                            </div>
            
                            <div class="row">
                                <input type="text" class="col-10" name="district_sent">
                            </div>
                        </div>
                    </div> --}}
                    {{-- hết tỉnh/huyện --}}

                    {{-- <div class="row mb-3">
                        <div class="col-4">
                            <div class="row">
                                Tên người gửi
                            </div>
                            <div class="row">
                                <input type="text" class="col-10" name="name_sent">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row">
                                Số điện thoại
                            </div>

                            <div class="row">
                                <input type="text" class="col-10" name="phone_sent">
                            </div>

                        </div>
                    </div> --}}

                    {{-- thông tin gói hàng --}}
                    {{-- <div class="row mb-3">
                       <div class="col-4">
                            <div class="row">
                                Trọng lượng (g)
                            </div>

                            <div class="row">
                                <input type="text" class="col-10" name="weight">
                            </div>
                       </div>

                       <div class="col-4">
                            <div class="row">
                                kích thước
                            </div>

                            <div class="row">
                                <input type="text" class="col-10" name="demension">
                            </div>
                       </div>

                    </div>

                    <div class="row">
                        <div class="col-4">
                            Loại ký gửi
                        </div>

                        <div class="row">
                            <select name="type_sending" id="" class="col-4">
                                <option value="fast">Nhanh</option>
                                <option value="eco">Tiết kiệm</option>
                            </select>
                        </div>
                    </div>

                </div> --}}
                {{-- hết bên trái --}}


                {{-- bên phải --}}
                {{-- <div class="col">
                    <div class="row mb-3">
                        Địa chỉ bên nhận:
                    </div>
                    <div class="row mb-3">
                        <input type="text" class="col-8" name="address_receive">
                    </div> --}}


                    {{-- cụm huyện/tỉnh --}}
                    {{-- <div class="row mb-3">
                    <div class="col-4">
                            <div class="row">
                                Tỉnh/Thành Phố
                            </div>
            
                            <div class="row">
                                <input type="text" class="col-10" name="province_receive">
                            </div>
                    </div>

                    <div class="col-4">
                            <div class="row">
                                Quận/Huyện/Thị xã 
                            </div>
            
                            <div class="row">
                                <input type="text" class="col-10" name="district_receive">
                            </div>
                        </div>
                    </div> --}}
                    {{-- hết cụm huyện tỉnh --}}

                    {{-- <div class="row mb-3">
                        <div class="col-4">
                            <div class="row">
                                Tên người nhận
                            </div>
                            <div class="row">
                                <input type="text" class="col-10" name="name_receive">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row">
                                Số điện thoại người nhận
                            </div>

                            <div class="row">
                                <input type="text" class="col-10" name="phone_receive">
                            </div>

                        </div>
                    </div>

                </div> --}}
                {{-- hết bên phải --}}
            {{--</div>
            <div class="text-center">
                <button class="btn btn-danger">Tạo đơn</button>
            </div>
        </form>
    </div> --}}
    <div class="form-w3layouts">
        <div class="row">
            <div class="col-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2>Tạo đơn Vận Chuyển</h2>
                    </header>
                    <div class="panel-body">
                        
                            <form role="form" method="post" action="{{URL::to('/creating-process')}}">
                                <div class="row">
                                {{ csrf_field() }}
                                {{-- bên trái --}}
                                <div class="col-sm-6 col-12">
                                    <div class="form-group row">
                                        <label for="address_sent" class="">Địa chỉ người gửi:</label>
                                        <div class="col-sm-10 col-12">
                                            <input type="text" class="form-control" id="address_sent" name="address_sent">
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 col-12 form-group row">
                                            <label for="province_sent" class="">Tỉnh/TP:</label>
                                            <div class="col-sm-10 col">
                                                <input type="text" class="form-control" id="province_sent" name="province_sent">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12 form-group row">
                                            <label for="district_sent">Quận/Huyện/TX</label>
                                            <div class="col-sm-10 col">
                                                <input type="text" class="form-control" id="district_sent" name="district_sent">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
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

                                    <div class="form-group row">
                                        <div class="col-sm-6 col-12 form-group row">
                                            <label for="weight" class="">Trọng lượng:</label>
                                            <div class="col-sm-10 col">
                                                <input type="text" class="form-control" id="weight" name="weight">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12 form-group row">
                                            <label for="demension">Kích thước:</label>
                                            <div class="col-sm-10 col">
                                                <input type="text" class="form-control" id="demension" name="demension">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row ">
                                        <div class="col-sm-6 col-12 form-group row">
                                            <label for="type_sending" class="">Loại ký gửi:</label>
                                            <div class="col-sm-10 col">
                                                <select class="form-select" id="type_sending" name="type_sending">
                                                    <option value="fast" selected>Nhanh</option>
                                                    <option value="eco">Tiết kiệm</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                {{-- bên phải --}}
                                <div class="col-sm-6 col-12">
                                    <div class="form-group row">
                                        <label for="address_receive" class="">Địa chỉ người nhận:</label>
                                        <div class="col-sm-10 col-12">
                                            <input type="text" class="form-control"  id="address_receive" name="address_receive">
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 col-12 form-group row">
                                            <label for="province_receive" class="">Tỉnh/TP:</label>
                                            <div class="col-sm-10 col">
                                                <input type="text" class="form-control" id="province_receive" name="province_receive">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-12 form-group row">
                                            <label for="district_receive">Quận/Huyện/TX:</label>
                                            <div class="col-sm-10 col">
                                                <input type="text" class="form-control" id="district_receive" name="district_receive">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
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

                            <div class="form-group text-center">
                                <button class="btn btn-danger">Tạo đơn</button>
                            </div>
                        </form>
                        
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection