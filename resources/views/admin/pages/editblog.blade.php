@extends('admin.dashboard')
@section('admin_content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Chỉnh sửa Blog</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{URL::to('/edit-blog/'.$blog->id_blog)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3 row">
                                <label for="editor">Tiêu đề</label>
                                <div class="col-sm-10 offset-sm-1"><textarea name="title" id="editor" class="form-control">{{$blog->blog_title}}</textarea>
                                @error('title')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="editor1">Nội dung</label>
                                <div class="col-sm-10 offset-sm-1"><textarea name="content" id="editor1" class="form-control">{{$blog->blog_content}}</textarea>
                                @error('content')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="editor2">Kết</label>
                                <div class="col-sm-10 offset-sm-1"><textarea name="end" id="editor2" class="form-control">{{$blog->blog_end}}</textarea>
                                @error('end')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="image1">Ảnh minh họa</label>
                                <div class="row">
                                    <div class="col-3"><img src="{{$blog->blog_image1}}" alt="error" width="100px" height="100px"></div>
                                    <div class="col-9">
                                        <input type="file" name="image1" id="image1" class="form-control mb-3">
                                        @error('image1')
                                            <label for="" class="text-danger">{{$message}}</label>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="image2">Ảnh minh minh họa thân bài viết</label>
                                <div class="row w-100">
                                    <div class="col-3"><img src="{{$blog->blog_image2}}" alt="error" width="100px" height="100px"></div>
                                    <div class="col-9">
                                        <input type="file" name="image2" id="image2" class="form-control mb-3">
                                        @error('image2')
                                            <label for="" class="text-danger">{{$message}}</label>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-2"><button class="btn btn-warning">Thay đổi!</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection