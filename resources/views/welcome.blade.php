<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLue Transfers</title>

    <!-- bootstraps 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- fontawnsome -->

    <!-- css -->
    <link rel="stylesheet" href="{{asset('/public/frontend/css/style.css')}}">
</head>
<body>
    <div class="container-fluid main-background">
        <!-- header -->
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light ">
                <div class="container-fluid ">
                    <a class="navbar-brand" href="{{URL::to('trang-chu')}}">THYNexpress</a>
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
                                <li><a class="dropdown-item" href="#">Tạo đơn</a></li>
                                <li><a class="dropdown-item" href="#">tính toán cước phí</a></li>
                                <li><a class="dropdown-item" href="#">Cách đóng gói</a></li>
                                <li><a class="dropdown-item" href="#">Danh mục cấm vận chuyển</a></li>
                                <li><a class="dropdown-item" href="#">Mạng lưới bưu cục</a></li>
                                <li><a class="dropdown-item" href="#">...</a></li>
                            </ul>
                        </li>
    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dịch vụ GTGT
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Thu hộ COD</a></li>
                                <li><a class="dropdown-item" href="#">Vận chuyển hỏa tốc</a></li>
                                <li><a class="dropdown-item" href="#">Giao hàng dể vỡ</a></li>
                                <li><a class="dropdown-item" href="#">...</a></li>
                                
                            </ul>
                        </li>
                        
                    </ul>
                    <div class="d-flex">
                        <a class="btn btn-primary me-2" href={{URL::to("/register")}}>Đăng Ký</a>
                        <a class="btn btn-primary" href={{URl::to('/login')}}>Đăng Nhập</a>
                    </div> 
                    </div>
                </div>
            </nav>
        </div>

        <div class="main">
            @yield('content')
        </div>

        <!-- footer -->
        <div class="row footer">
            <div class="col-lg-4 col-12 offset-lg-1 ">
                <h1 class="main-title">THYN Group</h1>
                <h3 class="main-title">Công ty TNHH THYN express</h3>
                <p>Trụ sở chính: 3/2 Ninh Kiều, Cần Thơ, Việt Nam</p>
                <p></p>
                <img src="{{asset('/public/frontend/images/check_bct.png')}}" alt="error">
            </div>
            <div class="col-lg-3 col-12">
                <h3 class="main-title">Vận chuyển nhanh</h3>
                <ul class="fast-trans">
                    <li><a href="">Tạo đơn hàng</a></li>
                    <li><a href="">Tính toán cước phí</a></li>
                    <li><a href="">Quy cách đóng gói</a></li>
                    <li><a href="">Mạng lưới bưu cục</a></li>

                </ul>
            </div>
            <div class="col-lg-2 col-12">
                <h3 class="main-title">Dịch vụ GTGT</h3>
                <ul class="fast-trans">
                    <li><a href="">Hàng hóa dễ vỡ</a></li>
                    <li><a href="">Hàng hóa cồng kềnh</a></li>
                    <li><a href="">Hàng Hóa giá trị cao</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-12">
                <h3 class="main-title">Mạng Xã Hội</h3>
                <div class="row"><a href="" class="nav-link text-light"><i class="bi bi-facebook"></i> FaceBook</a></div>
                <div class="row"><a href="" class="nav-link text-light"><i class="bi bi-tiktok"></i> TikTok</a></div>
                <div class="row"><a href="" class="nav-link text-light"><i class="bi bi-youtube"></i> Youtube</a></div>
                
            </div>
        </div>
    </div>
</body>
</html>