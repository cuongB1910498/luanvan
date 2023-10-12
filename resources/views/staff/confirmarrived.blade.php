@extends('staff.dashboard')
@section('staff-content')
<div class="container">
    <section class="panel">
        <header class="panel-heading mb-3">
            Scan để xác nhận đến:
        </header>
        @if (Session('error'))
        <div class="alert alert-danger">
            {{ Session('error') }}
        </div>
        @endif

        @if (session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}   
            </div>
        @endif

        <div class="panel-body">
            <div class="position-center">
                <form action="{{URL::to('/staff/arrived-process')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">  
                        <textarea name="input1" id="input1" class="form-control"></textarea>
                    </div>
    
                    <div class="form-group">
                        <button class="btn btn-info">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    
        <div class="row mb-3 mt-4">
            <div class="col-10 offset-2">
                <h1>Lưu ý khi scan bằng máy Scan:</h1>
            <ol>
                <li>Khi có lỗi, phải quét lại toàn bộ các đơn hàng vừa quét</li>
                <li>Khi Scan: hệ thống tự động chèn phím Tab và dấu phẩy </li>
                <li>Nên Scan từ 10 đơn đến 15 đơn, không nên scan quá nhiều để tránh lỗi</li>
            </ol>
            </div>  
        </div>
    </section>
</div>

<script>
    document.getElementById('input1').addEventListener('keydown', function (e) {
        if (e.keyCode === 9) {
            e.preventDefault(); // Ngăn chuyển đổi sang thẻ input khác
            const input1 = e.target;
            const currentValue = input1.value;
            const cursorPosition = input1.selectionStart;
            const newValue = currentValue.slice(0, cursorPosition) + ',' + currentValue.slice(cursorPosition);
            input1.value = newValue;
            input1.setSelectionRange(cursorPosition + 1, cursorPosition + 1);
        }
    });
</script>
@endsection