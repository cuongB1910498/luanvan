<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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
        })
    </script>
</body>
</html>