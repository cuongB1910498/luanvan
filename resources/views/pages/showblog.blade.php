@extends('welcome')
@section('content')
    <div class="container mb-3 mt-3">
        <div class="row justify-content-center">
            <div class="col-sm-3 bg-light">
                <h3>Bài viết liên quan</h3>
                @foreach ($get_blog_list as $row)
                
                    <div class="row mb-3">
                        <a href="{{URL::to('/blog/'.$row->id_blog)}}" style="text-decoration: none">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-img-top">
                                    <img src="{{$row->blog_image1}}" alt="error" width="100%" height="200px">
                                </div>
        
                                <div class="card-body">
                                    {!! $row->blog_title !!}
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                
                @endforeach
            </div>

            <div class="col-sm-9">
                <h1 class="text-center">{!! $blog->blog_title !!}</h1>
                <hr class="dropdown-divider bg-light mb-3" />
                <div class="row justify-content-center">
                    <div class="col-sm-5">
                        <img src="{{$blog->blog_image1}}" alt="" width="100%" height="400px">
                    </div>
                </div>
                <div class="mb-3">
                   {!! $blog->blog_content !!}
                </div>
                <div class="mb-3"><img src="{{$blog->blog_image2}}" alt="" width="100%" height="500px"></div>
                <div class="mt-3 mb-3">{!! $blog->blog_end !!}</div>
            </div>
        </div>
    </div>
@endsection