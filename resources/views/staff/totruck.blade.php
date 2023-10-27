@extends('staff.dashboard')
@section('staff-content')
    <div class="container">
        @if(Session('success'))
            <div class="alert alert-success">{{Session('success')}}</div>
        @endif
        @if(Session('error'))
            <div class="alert alert-danger">{{Session('error')}}</div>
        @endif
        <table class="table table-striped">
            <thead>
                <th>Tên giỏ</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th>Quản lý</th>
            </thead>

            <tbody>
               @foreach ($bag as $row)
                    
                    <tr>
                        <td>{{$row->bag_name}}</td>
                        <td>{{\Carbon\Carbon::parse($row->date)->format('d-m-Y')}}</td>
                        <td>
                            @if ($row->bag_status == 1)
                                Sẵn sàng
                            @else
                                @if ($row->bag_status == 0)
                                    Đã chuyển đi
                                @endif
                            @endif
                        </td>
                        <td>  
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" 
                                data-bs-target="#modal{{$row->id_bag}}"
                                @if ($row->bag_status == 0)
                                    disabled
                                @endif
                            >
                                Chuyển đi
                            </button>
                            <a href="{{URL::to('/staff/view-bag/'.$row->id_bag)}}" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                        </td>
                        <td>
                           
                        </td>
                    </tr>
                     <!-- Modal -->
                    <div class="modal fade" id="modal{{$row->id_bag}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chọn xe chuyển đi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{URL::to('/to-truck-process/'.$row->id_bag)}}" method="post">
                                @csrf
                                <div class="modal-body form-group row">
                                    <select name="id_truck" id="id_truck" class="form-select">
                                        @foreach ($select_truck as $truck)
                                            <option value="{{$truck->id_truck}}">{{$truck->bks.' | '. $truck->start_point.'-'. $truck->end_point}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                           
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                        </div>
                        </div>
                    </div>
               @endforeach
            </tbody>
        </table>
       
 
    </div>
@endsection