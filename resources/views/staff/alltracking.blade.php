@extends('staff.dashboard')
@section('staff-content')
    <div class="row">
        <div class="row">
            <div class="col-3">
                <select name="" id="selectId" class="form-select">
                    <option value="all" selected>Tất cả</option>
                    <option value="same">Giao Trong Tỉnh</option>
                    <option value="different">Giao Khu vực khác</option>
                </select>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped" id="">
                <thead>
                    <tr>
                        <th scope="col">Mã Vận Đơn</th>
                        <th scope="col">Tên Người nhận</th>
                        <th scope="col">Tên Người Gửi</th>
                        <th scope="col">Thời gian đến</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($get_all_tracking as $row)
                        <tr>
                            <th scope="row">{{ $row->id_tracking }}</th>
                            <td> {{ $row->name_sent }}</td>
                            <td> {{ $row->name_receive }}</td>
                            <td> {{ $row->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
            
        </div>

        <div id="resultDiv">

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
          $('#myTable').DataTable();

          $('#selectId').on('change', function() {
            var selectedValue = $(this).val();
            //alert(selectedValue);
              $.ajax({
                url: 'process-data',
                  method: 'GET',
                  data: {
                    selectedValue: selectedValue
                  },
                success: function(data) {
                  var tableBody = $('#tbody');
                  tableBody.empty();
                  $.each(data, function(key, row) {
                        var newRow = $('<tr>');
                        newRow.append('<th>' + row.id_tracking + '</th>');
                        newRow.append('<td>' + row.name_sent + '</td>');
                        newRow.append('<td>' + row.name_receive + '</td>');
                        newRow.append('<td>' + row.created_at + '</td>');
                        tableBody.append(newRow);
                    });
                },
                error: function() {
                  alert('Đã có lỗi xảy ra.');
                }
              });
            });
        });
    </script>
@endsection
