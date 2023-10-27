@extends('admin.dashboard')
@section('admin_content')
    <div class="table-agile-info">
        <div class="card panel-default">
            <div class="card-header">
                Station List
            </div>

            @yield('stationlist-table')

        </div>
    </div>
    <link rel="stylesheet" href="/DataTables/datatables.css" />
 
    <script src="/DataTables/datatables.js"></script>
    <script>
        $(document).ready( function () {
            $('#data').DataTable();
        } );
    </script>
@endsection
