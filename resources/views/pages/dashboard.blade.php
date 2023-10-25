<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
    <link rel="stylesheet" href={{ asset('/public/backend/css/bootstrap.min.css') }}>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href={{ asset('/public/backend/css/dataTables.bootstrap5.min.css') }}>
    <link rel="stylesheet" href={{ asset('/public/backend/css/style.css') }}>

    <title>THYN Express User</title>
    <style>
        body {
            font-family: "Trirong", sans-serif;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="{{ URL::to('/user') }}">Thyn
                Express</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar"
                aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavBar">
                <form class="d-flex ms-auto my-3 my-lg-0">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" />
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ URL::to('/user-profile') }}">
                                    <span>
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <span> Profile</span>
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="#"><span><i class="bi bi-gear"></i></span>
                                    Setting</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ URL::to('/logout') }}"> <span><i
                                            class="bi bi-key-fill"></i></span> Log-out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">

                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                            Vận Đơn
                        </div>
                    </li>
                    <li>
                        <a class="nav-link px-3" data-bs-toggle="collapse">
                            <span>Tạo Vận Đơn</span>
                        </a>
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="{{ URL::to('/create-tracking') }}" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-box-seam"></i></span>
                                        <span>Tạo Vận đơn</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ URL::to('/create-tracking-by-excel') }}" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-list-ul"></i></span>
                                        <span>Tạo Hàng Loạt</span>
                                    </a>
                                </li>
                            </ul>
                        


                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider bg-light" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                            Địa Chỉ
                        </div>
                    </li>

                    <li>

                        <ul class="navbar-nav ps-3">
                            <li>
                                <a href="{{ URL::to('add-address') }}" class="nav-link px-3">
                                    <span class="me-2"><i class="bi bi-plus-lg"></i></span>
                                    <span>Thêm Địa chỉ mới</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ URL::to('/my-address') }}" class="nav-link px-3">
                                    <span class="me-2"><i class="bi bi-house"></i></span>
                                    <span>Địa chỉ của tôi</span>
                                </a>
                            </li>
                        </ul>


                    </li>




                    <li class="my-4">
                        <hr class="dropdown-divider bg-light" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                            Chi Tiết Vận Đơn
                        </div>
                    </li>
                    <li>
                        <a href="{{ URL::to('/list-tracking') }}" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-collection"></i></span>
                            <span>Vận đơn của tôi</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{URL::to('/vat-preview')}}" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-journal"></i></span>
                            <span>Xuất hóa đơn VAT</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ URL::to('/located') }}" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-pin-map"></i></span>
                            <span>Theo dõi</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
        <div class="container-fluid">

            @yield('user_content')

        </div>
    </main>
    <script src={{ asset('public/backend/js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js') }}></script>
    <script src={{ asset('public/backend/js/jquery-3.5.1.js') }}></script>
    <script src={{ asset('public/backend/js/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('public/backend/js/dataTables.bootstrap5.min.js') }}></script>
    <script src={{ asset('public/backend/js/script.js') }}></script>
    <script src="{{ asset('public/frontend/js/datatable.js') }}"></script>
    <script src="{{asset('public/frontend/js/select_district.js')}}"></script>
    <script src="{{ asset('public/frontend/js/searchtracking.js') }}"></script>
    {{-- <script>
        
        $(document).ready(function () {
        $('#tracking-form').submit(function (e) {
            e.preventDefault();

            // Lấy dữ liệu từ trường textarea
            var trackingData = $('textarea[name="tracking"]').val();

            // Gửi dữ liệu bằng Ajax
            $.ajax({
                url: 'process-tracking',
                type: 'POST',
                data: { 
                    _token: '{{csrf_token()}}',
                    tracking: trackingData 
                },
                dataType: 'json',
                success: function (data) {
                    // Xử lý kết quả JSON
                    displayResults(data);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        function displayResults(data) {
            var resultsContainer = $('#results');
            resultsContainer.empty();

            // Duyệt qua kết quả JSON và hiển thị từng đơn
            $.each(data, function (trackingId, items) {
                var trackingResult = $('<div>');

                if (items.length === 0) {
                    trackingResult.html(trackingId + ': Không có thông tin.');
                } else {
                    trackingResult.append(trackingId + ':<ul>');
                    $.each(items, function (index, item) {
                        trackingResult.append('<li>' + item.note + '</li>');
                    });
                    trackingResult.append('</ul>');
                }

                resultsContainer.append(trackingResult);
            });
        }
    });

    </script> --}}
</body>

</html>
