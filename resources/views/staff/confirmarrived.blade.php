@extends('staff.dashboard')
@section('staff-content')
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Confirm arrived
        </header>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}<li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('msg'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('msg') }}<li>
                </ul>
            </div>
        @endif
        <div class="panel-body">
            <div class="position-center">
                <form action="{{URL::to('/staff/arrived-process')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">  
                        <textarea name="input1" id="input1" class="form-control"></textarea>
                    </div>
    
                    <div class="form-group">
                        <button class="btn btn-info">Xác nhận</button>
                    </div>
                </form>
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