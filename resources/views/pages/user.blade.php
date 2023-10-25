@extends('pages.dashboard')
@section('user_content')
    <div class="container user_content">
        <div class="row text-center">
            <h1 class="mb-3">Bạn đã trải nghiệm dịch vụ chuyển hàng của ThynExpress chưa!</h2>
            <p>Cùng bắt đầu tạo đơn hàng mới với: </p>
            <div class="tao_don text-center mb-3"> 
                <button class="nut_tao btn btn-lg btn-primary"><a href="{{URL::to('/create-tracking')}}" class="text-light nav-link"><i class="bi bi-archive"></i> Bắt đầu tạo đơn hàng</a></button>
            </div>

            
            <div class="tracuu text-center mt-3 mb-3">
                <p>Đơn hàng tới đâu rồi nhỉ?</p>
                <form id="search">
                    <h2 class="mb-3">Kiểm tra đơn hàng</h2>
                    <div class="form-group mb-2">
                        <div class="kiemtradon row">
                            <div class="col-8 offset-2">
                                <input type="text" name="tracking" class="form-control col-10" style="margin-right: 10px">
                            </div>
                            <button class="btn col-1"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="me-2">lưu ý nhỏ là chỉ kiểm tra đơn của mình thôi nhé hoặc có thể vào: <a class="nav-link" href="{{URL::to('/list-tracking')}}">Quản lý đơn hàng</a></p>
                    </div>
                    <div id="kq"></div>
                </form>
            </div>
        </div>
    </div>
    <script src={{ asset('public/backend/js/jquery-3.5.1.js') }}></script>
    <script>
    $(document).ready(function () {
        $('#search').submit(function (e) {
            e.preventDefault();

            // Lấy dữ liệu từ trường textarea
            var trackingData = $('input[name="tracking"]').val();

            // Gửi dữ liệu bằng Ajax
            $.ajax({
                url: 'process-tracking',
                type: 'POST',
                data: { 
                    _token: $('meta[name="csrf-token"]').attr('content'),
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
            var resultsContainer = $('#kq');
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
    </script>
@endsection