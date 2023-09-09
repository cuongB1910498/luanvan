@extends('pages.dashboard')
@section('user_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách đơn hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:10%;">Mã đơn</th>
                            <th style="width:15%;">Tên người nhận</th>
                            <th style="width:50%;">Địa chỉ</th>
                            <th>SDT</th>
                            <th style="width:3%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td> {{ $row->id_tracking }} </td>
                                <td> {{ $row->name_receive }} </td>
                                <td> {{ $row->address_receive.', '.$row->district_receive.', '.$row->province_receive }}</td>
                                <td> {{ $row->phone_receive}} </td>
                                <td>
                                    <a href="{{URL::to('/view-tracking/'.$row->id_tracking)}}" class="active" ui-toggle-class="">
                                        <i class="fa fa-eye text-success text-active"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <footer class="panel-footer">
        <div class="row">
          
          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
          </div>
          <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
              <li><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>
      </footer> --}}
        </div>
    </div>
@endsection
