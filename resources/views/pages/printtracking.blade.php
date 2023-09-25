<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>in đơn: {{$tracking->id_tracking}}</title>

    <link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css.map')}}">

    <script src="{{asset('public/backend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/backend/js/bootstrap.bundle.min.js.map')}}"></script>
    <style>
        body{
            font-family: 'Dejavu Sans', sans-serif;
        }
        .page-header {
            float: left;
        }

        .le{
            width: 40%;
        }

        .mid{
            width: 45%;
        }
        .clear-fix{
            clear: both;
        }
        
        .main-page{
            float: left;
            
        }

        .footer-page{
            width: 70%;
            margin: 0px auto
        }

        .hidden-part {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            padding: 0 5px; /* Điều chỉnh khoảng cách để che đi phần số ẩn */
            z-index: 1;
        }
        
    </style>
</head>
<body>
    {{-- <div class="showcode">
        @php
            echo DNS1D::getBarcodeHTML($id_tracking->id_tracking, 'C128', 1,60, 'black', true);
            echo DNS2D::getBarcodeHTML($id_tracking->id_tracking, 'QRCODE', 4,4);
        @endphp
   </div> --}}

    <div class="page-header le">
        @php
            echo DNS1D::getBarcodeHTML($tracking->id_tracking, 'C128', 2,40);
        @endphp
        <p>{{$tracking->id_tracking}}</p>
    </div>
    <div class="page-header mid">
        <h1>Thyn Express</h1>
        <p>Dịch Vụ Vận Chuyển uy tín</p>
    </div>
    <div class="page-header ri">
        @php
            echo DNS2D::getBarcodeHTML($tracking->id_tracking, 'QRCODE', 4,4);
        @endphp
        
    </div>

    <div class="clear-fix"></div>

    <div class="main-page" style="width:45%"> 
       <p>Bên gửi:</p>
       <p>{{$tracking->name_sent}} - {{$tracking->address_sent}}, {{$sender->district_name}}, {{$sender->province_name}}</p>
       <p>{{$tracking->phone_sent}}</p>
    </div>
    <div class="main-page" style="width:10%"></div>
    <div class="main-page" style="width:45%">
        <p>Bên nhận:</p>
        <p>{{$receive->name_receive}} - {{$receive->address_receive}}, {{$receive->district_name}}, {{$receive->province_name}}</p>
       
        <p>{{$tracking->phone_receive}}</p>
        <div id="result"></div>
    </div>

    <div class="clear-fix"></div>

    <div class="footer-page">
        <p>Nội dung hàng hóa: {{$tracking->describe_tracking}}</p>
    </div>

    <div class="cod">
        <h2>COD: {{number_format($tracking->cod, 0, ',', '.')}} VND</h2>
    </div>


</body>
</html>