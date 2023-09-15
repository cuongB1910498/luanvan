@extends('pages.dashboard')
@section('user_content')
    <div class="row mt-3 mb-3">
        <div class="col-10 offset-lg-1">
            <h2>Mã vận đơn: {{ $id_tracking }}</h2>
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Thời gian</th>
                    
                  </tr>
                </thead>
                <tbody>
                    @foreach ($get_tracking as $row)
                        <tr>
                            <td>{{ $row->note }}</td>
                            <td> {{ $row->created_at }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection