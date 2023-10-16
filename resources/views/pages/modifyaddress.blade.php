@extends('pages.dashboard')
@section('user_content')
    <div class="container row">
        <div class="card col-6 offset-3">
            <div class="card-header">
                <h1>Chỉnh sửa địa chỉ</h1>
            </div>
            <div class="card-body">
                <form action="{{ URL::to('/modify-address-process/'.$get_address->id_address) }}" method="POST">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="address_name">Tên địa chỉ: </label>
                        <div class="col">
                            <input type="text" value="{{$get_address->address_name}}" placeholder="Tên địa chỉ để phân biệt các địa chỉ với nhau" class="form-control" name="address_name" id="address_name">
                            @error('address_name')
                                <label class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="address_sent">Địa chỉ (Càng cụ thể càng tốt): </label>
                        <div class="col">
                            <input type="text" placeholder="số nhà, tên đường, khu phố, tổ, ấp, xóm, khu vực" class="form-control" name="address_sent" id="address_sent" value="{{$get_address->address_sent}}">
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
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary">Hiệu chỉnh</button>
                        </div>
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
                // cẩn thận URL, chắt ăn thì bật F12 lên coi lại nhé
                url: '/thynx/select-province',
                method: 'GET',
                data: {
                    selectedValue: selectedValue
                },
                success: function(data) {
                    //var district_sent =$('#district_sent');
                    $('#district_sent').empty();
                    //console.log(data);
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
        })
    </script>
@endsection