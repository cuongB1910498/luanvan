@extends('admin.dashboard')
@section('admin_content')
    <div class="container">
        @if(Session('success'))
        <div class="alert alert-success">{{Session('success')}}</div>
        @endif
        @if(Session('error'))
        <div class="alert alert-danger">{{Session('error')}}</div>
        @endif
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <table class="table table-light table-striped" id="myTable">
                    <thead>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Ảnh minh họa</th>
                        <th>Ảnh thân bài viết</th>
                        <th>Ngày tạo</th>
                        <th>QL</th>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($list_blog as $row)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{ $row->blog_title }}</td>
                                <td><img alt="error" width="100px" height="100px" src="{{$row->blog_image1}}"></td>
                                <td><img alt="error" width="100px" height="100px" src="{{$row->blog_image2}}"></td>
                                <td>{{$row->created_at}}</td>
                                <td>
                                    <a href="{{URL::to('/edit-blog/'.$row->id_blog)}}" class="btn btn-warning"><i class="bi bi-gear"></i></a> 
                                    <a href="{{URL::to('/delete-blog/'.$row->id_blog)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắt muốn xóa?!')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection