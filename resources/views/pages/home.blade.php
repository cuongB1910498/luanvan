@extends('welcome')
@section('content')
<!-- getting start -->
<div class="row get-start">
    <a href="{{URL::to('/create-tracking')}}" class="btn btn-primary btn-lg custom-btn-start">Tạo Đơn Ngay</a>
</div>


<div class="row">
    <div class="col">
        <img src="https://res.cloudinary.com/dx3ymfyd4/image/upload/v1694676429/Frame_15_toggmo.png" alt="" id="img">
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
    <div class="row">
        <h1 class="text-center mb-3 mt-3">Tại sao bạn nên chọn ThynExpress</h1>
        <div class="row">
            <div class="col-sm-2 offset-sm-2"><img src="{{asset('/public/frontend/images/fast_service.png')}}" alt=""></div>
            <div class="col-sm-8">
                <p style="padding-top: 90px">Chúng tôi luôn cố gắn không ngừng cải thiện dịch vụ của mình nhanh hơn, để khách hàng có sự trãi nghiệp tốt nhất</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-7 offset-sm-2">
                <p style="padding-top: 90px">Trong quá trình vận chuyển, hàng hóa của bạn sẽ được đảm bảo an toàn, hạn chế thấp nhất các tình trạng hỏng hóc trong quá trình vận chuyển</p>
            </div>
            <div class="col-sm-2"><img src="{{asset('/public/frontend/images/safety.png')}}" alt=""></div>
        </div>

        <div class="row text-center">
            <p>Đặc biệt giá cả vô cùng hợp lý, có tính cạnh tranh cao</p>
        </div>
    </div>

    <div class="row doitac">
        <h1 class="text-center mb-3 mt-3">Các đối tác tin cậy</h1>
        
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
</div>

@endsection