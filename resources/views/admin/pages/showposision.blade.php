@extends('admin.dashboard')
@section('admin_content')
    <div class="container">

        <div class="card">
            <div class="update-msg">
                <?php
                $msg_update = Session::get('msg_update');
                if ($msg_update) {
                    echo $msg_update;
                    Session::put('msg_update', null);
                }
                ?>
            </div>
            <div class="card-header">
                POSISION LIST
            </div>
            <div class="card-body">
                <table class="table table-light table-striped" ui-jq="footable"
                    ui-options='{
                "paging": {
                "enabled": true
                },
                "filtering": {
                "enabled": true
                },
                "sorting": {
                "enabled": true
                }}'>
                    <thead>
                        <tr>
                            <th data-breakpoints="xs">ID</th>
                            <th>Posision Name</th>
                            <th>Lvl Salary</th>
                            <th>Manager</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posision_list as $row)
                            <tr data-expanded="true">
                                <td>{{ $row->id_posision }}</td>
                                <td>{{ $row->posision_name }}</td>
                                <td>{{ $row->lvl_salary }}</td>
                                <td>
                                    <a href="{{ URL::to('/edit-posision/' . $row->id_posision) }}"
                                        class="btn btn-warning">Edit</a>
                                    <a href="{{ URL::to('/delete-posision/' . $row->id_posision) }}" class="btn btn-danger"
                                        onclick="return confirm('Are you sure to Delete Posision?!')">Delete</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
