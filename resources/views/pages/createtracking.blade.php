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

                        <div class="form-group row mb-3">
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

                        <div class="form-group row mb-3 ">
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
                                    <input type="text" class="form-control" id="province_receive"
                                        name="province_receive">
                                </div>
                            </div>

                            <div class="col-sm-6 col-12 form-group row">
                                <label for="district_receive">Quận/Huyện/TX:</label>
                                <div class="col-sm-10 col">
                                    <input type="text" class="form-control" id="district_receive"
                                        name="district_receive">
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

                <div class="form-group text-center">
                    <button class="btn btn-primary">Tạo đơn</button>
                </div>
            </form>

        </div>


    </div>
    </div>
@endsection
