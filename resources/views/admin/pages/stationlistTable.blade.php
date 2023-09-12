@extends('admin.pages.stationlist')
@section('stationlist-table')
<div class="table-responsive">
    <table class="table table-striped b-t b-light">
        <thead>
            <tr>
                <th style="width:10px;">STT</th>
                <th>Posision Name</th>
                <th>Address</th>
                <th>Province</th>
                <th style="width:30px;"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            ?>
            @foreach ($get_station as $row)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $row->station_name }}</td>
                    <td>{{ $row->address }}</td>
                    <td>{{ $row->province_name }}</td>
                    <td>
                        <a href="{{URL::to('/station/'.$row->id_station)}}" class="active" ui-toggle-class="">
                            <i class="fa fa-eye text-success text-active"></i>
                        </a>
                    </td>
                </tr>
                <?php 
                    $i++
                ?>
            @endforeach
            

            
        </tbody>
    </table>
</div>
@endsection