@extends('welcome')
@section('content')
    <div class="container">
        <h1 class="text-center" style="font-size:80px">Các bài viết nổi bật</h1>
        <div class="row justify-content-center">
            <div class="col-sm-8">
                @foreach ($get_blog as $row)
                    <div class="row mb-3">
                        <a href="{{URL::to('/blog/'.$row->id_blog)}}" class="row" style="text-decoration: none;" >
                            <img src="{{$row->blog_image1}}" alt="" width="100%" height="150px" class="col-sm-3" style="padding-right: 0px">
                            <div class="col bg-light">
                                <h2 class="nav-link text-dark">{!! $row->blog_title !!}</h2>
                            </div>
                        </a>
                    </div>
                    
                @endforeach
                {{ $get_blog->links() }}
            </div>
        </div>
    </div>
@endsection