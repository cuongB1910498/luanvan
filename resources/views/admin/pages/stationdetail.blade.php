@extends('admin.dashboard')
@section('admin_content')
    <div class="table-agile-info">
        <div class="table-responsive">
            <div class="panel-heading">
                {{$get_station->station_name}}
            </div>
            <div class="panel panel-default">
                <?php
                    $msg_update = Session::get('msg_update');
                    if($msg_update){
                ?>
                <div class="error text-center" style="color: red">
                <?php
                    echo $msg_update;
                ?>
                </div>
                <?php
                    Session::put('msg_update', null);
                    }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:10px;">STT</th>
                            <th>Staff Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Posision</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($get_staff as $row)
                        <?php 
                            $i = 1;
                        ?>
                        <tr>
                            <td> {{$i}} </td>
                            <td> {{$row->staff_name }} </td>
                            <td> {{$row->staff_phone}} </td>
                            <td> {{$row->staff_email}} </td>
                            <td> {{$row->posision_name}} </td>
                            <td>
                                <a href="{{URL::to('/edit-staff/'.$row->id_staff)}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-wrench text-success text-active"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                            $i++;
                        ?>

                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
