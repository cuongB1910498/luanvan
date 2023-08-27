@extends('welcome')
@section('content')
<!-- getting start -->
<div class="row get-start">
    <a href="#" class="btn btn-primary btn-lg custom-btn-start">Tạo Đơn Ngay</a>
</div>

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
            <img src="https://res.cloudinary.com/dx3ymfyd4/image/upload/v1681869928/r5%203400g.jpg.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="https://res.cloudinary.com/dx3ymfyd4/image/upload/v1681869928/r5%203400g.jpg.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="https://res.cloudinary.com/dx3ymfyd4/image/upload/v1681869928/r5%203400g.jpg.jpg" class="d-block w-100" alt="...">
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



<!-- search bar -->
<div class="mb-3 bg-light box-search">
    <form action="" class="row">
        <div class="col-lg-8 col-8 offset-lg-1">
            <input type="search" class="form-control" placeholder="Tra cứu mã vận đơn">
        </div>
        <button type="submit" class="btn btn-primary col-lg-2 col-3 custom-btn" >Kiểm tra</button>
    </form>
</div>

<!-- main ad -->
<div class="row main-ad">
    quảng cáo chính
</div>
@endsection