@extends('welcome')
@section('content')
<!-- getting start -->
@if(Session('id_user'))
<div class="row get-start">
    <a href="{{URL::to('/create-tracking')}}" class="btn btn-primary btn-lg custom-btn-start">Tạo Đơn Ngay</a>
</div>
@endif


<div class="row mt-3">
    <div class="col">
        <img src="{{asset('/public/frontend/images/ThynExpressLogo.png')}}" alt="" id="img">
    </div>
    <div class="col">
        <!-- Carousel slider -->
        <div class="d-block mb-3" id="carousel_slide">
            <div id="carouselExampleIndicators" class="carousel slide custom-carousel" data-bs-ride="carousel" >
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img src="https://res.cloudinary.com/dx3ymfyd4/image/upload/v1694674095/design_bds_5_h0pecj.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                    <img src="https://res.cloudinary.com/dx3ymfyd4/image/upload/v1694674095/design_bds_5_h0pecj.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                    <img src="https://res.cloudinary.com/dx3ymfyd4/image/upload/v1694674095/design_bds_5_h0pecj.png" class="d-block w-100" alt="...">
                    </div>
                    </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div> 
        </div>
    </div>
</div>




<!-- search bar -->
<div class="mb-3 bg-light box-search">
    <form action="{{URL::to('/')}}" class="row" method="get">
        <div class="col-lg-8 col-8 offset-lg-1">
            <input type="search" class="form-control" placeholder="Tra cứu mã vận đơn" name="tracking">
        </div>
        <button type="submit" class="btn btn-primary col-lg-2 col-3 custom-btn" id="search-button">Kiểm tra</button>
    </form>
</div>

@if (Session('error'))
    <div class="alert alert-danger" id="results-section">
        {{Session('error')}}
    </div>
@endif

@if (isset($tracking))
<div class="row" id="results-section">
    <div class="card col-sm-8 offset-sm-2">
        <div class="card-header">Mã đơn: {{$info}}</div>
        <div class="card-body">
            <ul>
                @foreach ($tracking as $row)
                    <li>{{$row->note}} | {{\Carbon\Carbon::parse($row->created_at)->format('H:m:s d/m/Y')}}</li>
                @endforeach
                
                
            </ul>
        </div>
    </div>
    
</div> 
@endif

<!-- main ad -->
<div class="row main-ad">
    <div class="row gioithieu">
        <h1 class="text-center mb-5">Tại sao bạn nên chọn ThynExpress</h1>
        <div class="row mb-5">
            <div class="col-sm-2 offset-sm-2 offset-sm-0 offset-3"><img src="{{asset('/public/frontend/images/fast_service.png')}}" alt=""></div>
            <div class="col-sm-7">
                <p >Chúng tôi luôn cố gắn không ngừng cải thiện dịch vụ của mình nhanh hơn, để khách hàng có sự trãi nghiệm tốt nhất</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-sm-7 offset-sm-2 ">
                <p>Trong quá trình vận chuyển, hàng hóa của bạn sẽ được đảm bảo an toàn, hạn chế thấp nhất các tình trạng hỏng hóc</p>
            </div>
            <div class="col-sm-2 offset-sm-0 offset-3"><img src="{{asset('/public/frontend/images/safety.png')}}" alt=""></div>
        </div>

        <div class="row mb-4 text-center">
            <div class="col-sm-2 offset-sm-5 offset-1">
                <img src="{{asset('/public/frontend/images/good_price.png')}}" alt="">
            </div>
            <p>Đặc biệt giá cả vô cùng hợp lý, có tính cạnh tranh cao</p>
        </div>
    </div>

    <div class="row doitac">
        <h1 class="text-center mb-5 mt-3">Các đối tác tin cậy</h1>
        
            <div class="col-sm-3 col offset-lg-2">
                <img src="{{asset('/public/frontend/images/ali.jpg')}}" alt="error" width="150px" height="100px" class="row">
                <p class="row ali">Aliexprexx</p>
            </div>
            <div class="col-sm-3 col">
                <img src="{{asset('/public/frontend/images/shoppe.png')}}" alt="error" width="100px" class="row">
                <p class="row sp">Shoppee</p>
                
            </div>
            <div class="col-sm-3 col">
                <img src="{{asset('/public/frontend/images/laza.png')}}" alt="error" width="100px" class="row">
                <p class="row ldz">Ladaza</p>
            </div>   
    </div>

    <div class="row mb-3 mt-3">
        <div class="col-sm-8 col-12 offset-sm-2 mb-3 mt-3">
            <h2>Trụ sở chính: 3/2 Ninh Kiều, Cần Thơ</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d9344.548991832879!2d105.77180351080722!3d10.025203303494406!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1698200722922!5m2!1svi!2s" 
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="col-sm-8 col-12 offset-sm-2">
            <h2>VPĐD: Tp Châu Đốc, An Giang</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15681.39118598205!2d105.11661605585776!3d10.707634488156879!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1698201001349!5m2!1svi!2s" 
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>

@endsection