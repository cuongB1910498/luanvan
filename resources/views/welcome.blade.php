<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLue Transfers</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
    <!-- bootstraps 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- fontawnsome -->

    <!-- css -->
    <link rel="stylesheet" href="{{asset('/public/frontend/css/style.css')}}">
</head>
<body>
    <div class="container-fluid">
        <!-- header -->
        <div class="header">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{URL::to('/')}}">THYNexpress</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Vận chuyển Nhanh
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{URL::to('/create-tracking')}}">Tạo đơn</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/calculate-price')}}">Tính toán cước phí</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/how-to-pack')}}">Cách đóng gói</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/prohibited-list')}}">Danh mục cấm vận chuyển</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/station-list')}}">Mạng lưới bưu cục</a></li>
                                
                            </ul>
                        </li>
    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dịch vụ GTGT
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{URL::to('/cod-service')}}">Thu hộ COD</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/extremefast-service')}}">Vận chuyển hỏa tốc</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/safe-service')}}">Giao hàng dể vỡ</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{URL::to('/blog/')}}">
                                BLOG
                            </a>
                        </li>
                        
                    </ul>
                    @if(Session('id_user'))
                    <div class="d-flex">
                        <a class="btn btn-primary me-2" href="{{URL::to('/user')}}">Trang cá nhân</a>
                        <a class="btn btn-danger" href="{{URL::to('/logout')}}">Đăng xuất</a>
                    </div>
                    @else
                    <div class="d-flex">
                        <a class="btn btn-primary me-2" href={{URL::to("/register")}}>Đăng Ký</a>
                        <a class="btn btn-primary" href={{URl::to('/login')}}>Đăng Nhập</a>
                    </div>
                    @endif
                    </div>
                </div>
            </nav>
        </div>

        <div class="main container">
            @yield('content')
        </div>

        <!-- footer -->
        <div class="row footer">
            <div class="col-lg-4 col-12 offset-lg-1 ">
                <h1 class="main-title">THYN Group</h1>
                <h3 class="main-title">Công ty TNHH THYN express</h3>
                <p>Trụ sở chính: 3/2 Ninh Kiều, Cần Thơ, Việt Nam</p>
                <p></p>
                <a href="http://online.gov.vn" target="_blank"><img src="{{asset('/public/frontend/images/check_bct.png')}}" alt="error"></a>
                
            </div>
            <div class="col-lg-3 col-12">
                <h3 class="main-title">Vận chuyển nhanh</h3>
                <ul class="fast-trans">
                    <li><a href="{{URL::to('/create-tracking')}}">Tạo đơn hàng</a></li>
                    <li><a href="{{URL::to('/calculate-price')}}">Tính toán cước phí</a></li>
                    <li><a href="{{URL::to('/how-to-pack')}}">Quy cách đóng gói</a></li>
                    <li><a href="{{URL::to('/station-list')}}">Mạng lưới bưu cục</a></li>
    
                </ul>
            </div>
            <div class="col-lg-2 col-12">
                <h3 class="main-title">Dịch vụ GTGT</h3>
                <ul class="fast-trans">
                    <li><a href="{{URL::to('/safe-service')}}">Hàng hóa dễ vỡ</a></li>
                    <li><a href="{{URL::to('/safe-service')}}">Hàng hóa cồng kềnh</a></li>
                    <li><a href="{{URL::to('/safe-service')}}">Hàng Hóa giá trị cao</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-12">
                <h3 class="main-title">Mạng Xã Hội</h3>
                <div class="row"><a href="https://facebook.com" class="nav-link text-light" target="_blank"><i class="bi bi-facebook"></i> FaceBook</a></div>
                <div class="row"><a href="https://tiktok.com" class="nav-link text-light" target="_blank"><i class="bi bi-tiktok"></i> TikTok</a></div>
                <div class="row"><a href="https://youtube.com" class="nav-link text-light" target="_blank"><i class="bi bi-youtube"></i> Youtube</a></div>
                
            </div>
        </div>
    </div>
    
</body>
</html>