@extends('staff.dashboard')
@section('staff-content')

    <div class="container">
        <h2>Các đơn cần giao</h2>
        @if (Session('success'))
            <div class="alert alert-success">{{Session('success')}}</div>
        @endif

        @if (Session('error'))
            <div class="alert alert-warning">{{Session('error')}}</div>
        @endif
        
        <table class="table table-striped">
            <thead>
                <th style="width:35%">Địa chỉ người nhận</th>
                <th>Tên người nhận</th>
                <th>SDT</th>
                <th style="width:30%">Thao Tác</th>
            </thead>
            @if ($tracking->isEmpty())
                <tbody>
                    <tr><td colspan="4" class="text-center">Hiện giỏ hàng của bạn đang trống!</td></tr>
                </tbody> 
            @else
            <tbody>
               @foreach ($tracking as $row)
                   <tr>
                        <td>{{$row->address_receive}}</td>
                        <td>{{$row->name_receive}}</td>
                        <td>{{$row->phone_receive}}</td>
                        <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{$row->id_tracking}}">Hoàn thành</button>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#deliverfail">Không thành công</button>
                        </td>
                   </tr>
                   {{-- complete modal --}}
                    <div class="modal fade" id="{{$row->id_tracking}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Chụp một bức ảnh để hoàn thành đơn hàng</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{URL::to('/deliver-complete/'.$row->id_tracking)}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-body form-group row">
                                    <label for="" class="mb-3">Chọn ảnh</label>
                                    <div class="col">
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>

                    <!-- fail Modal -->
                    <div class="modal fade" id="deliverfail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Chọn lý do giao thất bại</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{URL::to('/deliver-fail/'.$row->id_tracking)}}" method="POST">
                                {{ csrf_field() }}
                                <div class="modal-body" class="form-group row">
                                    <label for="lydo">Lý do:</label>
                                    <select name="lydo" id="lydo" class="form-select">
                                        <option value="Khách không nghe máy">Khách không nghe máy</option>
                                        <option value="Khách không nhận hàng">Khách không nhận hàng</option>
                                        <option value="Không tìm được địa chỉ giao hàng">Không tìm được địa chỉ giao hàng</option>
                                        <option value="Khách hàng hẹn nhận ngày khác">Khách hàng hẹn nhận ngày khác</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                            
                            </div>
                        </div>
                        </div>
                    </div>
               @endforeach
            </tbody>
            @endif
        </table>
    </div>

    
@endsection