@extends('staff.dashboard')
@section('staff-content')
    @if (Session::get('error'))
        <div class="alert bg-warning">bạn chưa được cấp xe tải</div>
    @else
    <div class="container">
        @if (Session::get('msg'))
            <p>{{Session::get('msg')}}</p>
        @endif
        <div class="row">
            @if ($get_truck_info->id_truck_status >= '2')
                <div class="col row">
                    <h2>Manager</h2>
                    @if ($get_truck_info->id_truck_status == '4')
                        <div class="col">
                            <button class="btn btn-default btn-primary" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Xác nhận đến(mở modal)</button>
                            
                        
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Choice a Station</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/thynx/truck-log" method="GET">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" hidden name="process" value="arrived">
                                                <input type="text" hidden name="id_truck" value="{{$get_truck_info->id_truck}}">
                                                <select name="id_station" id="" class="form-select">
                                                   
                                                    @foreach ($get_station as $station)
                                                        <option value="{{$station->id_station}}">{{$station->station_name}}</option>
                                                    @endforeach
                                                    
                                        
                                                    
                                                </select>
                                            </div>  
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Confirm</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            @else
                    <div class="col">
                        <a href="{{URL::to('/truck-log?process=roaldout&id_truck='.$get_truck_info->id_truck.'&id_station='.$current_station->id_station)}}" class="btn btn-dark "> Khởi hành</a> 
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_1">Giao gói hàng</button>
                        <a href="{{URL::to('/truck-log?process=checkout&id_truck='.$get_truck_info->id_truck.'&id_station='.$current_station->id_station)}}" class="btn btn-default btn-danger ">Kết thúc phiên</a>
                    </div>
                    <div class="modal fade" id="modal_1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Chọn gói hàng giao Trạm</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{URL::to('/truck-log')}}" method="get">
                                @csrf
                            <div class="modal-body form-group row">
                                <input type="text" class="visually-hidden" value="bagout" name="process">
                                <input type="text" class="visually-hidden" value="{{$get_truck_info->id_truck}}" name="id_truck">
                                <select name="id_bag" id="id_bag" class="form-select">
                                    @foreach ($truck_bag as $bag)
                                        <option value="{{$bag->id_bag}}">{{$bag->bag_name.' từ: '.$bag->station_name}}</option>
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
                    @endif
                </div>
            @else
                <div class="col">
                    <h2>Check In Start Work</h2>
                    <a href="{{URL::to('/truck-log?process=checkin&id_truck='.$get_truck_info->id_truck)}}" class="btn btn-primary">check in</a>
                </div>
            @endif
            <div class="col">
                <h2>Truck Infomation</h2>
                <div class="row">
                    <p class="col-lg-4">BKS: {{$get_truck_info->bks}}</p>
                    <p class="col">Tuyến: {{$get_truck_info->start_point.' - '.$get_truck_info->end_point}}</p>
                    <p class="col">{{ $get_truck_info->name_status}}</p>
                </div>
                
            </div>
        </div>

        <div class="row">
            <h2 class="text-center">Truck Log today</h2>
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Station</th>
                    <th scope="col">Note</th>
                    <th scope="col">Datetime</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($get_log_today as $log)
                        <tr>
                            <th scope="row">{{$log->truck_status}}</th>
                            <td>{{$log->station_name}}</td>
                            <td>{{$log->note}}</td>
                            <td>{{\Carbon\Carbon::parse($log->create_at)->format('d-m-Y H:i:s')}}</td>
                        </tr>
                    @endforeach
                  
            
                </tbody>
              </table>
        </div>
        
    </div>
    @endif
@endsection