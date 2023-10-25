@extends('pages.dashboard')
@section('user_content')
    <div class="container">
        @if ($tracking->isEmpty())
            <p>Có vẽ như tháng rồi chưa có đon nào</p>
        @else
            
        
        <h3>Xuất hóa đơn VAT cho {{$last_month.'/'.$this_year}}</h3>
        <table class="table table-light table-striped">
            <thead>
                <th>Mức giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </thead>
            @php
                $count = 0;
            @endphp
            <tbody>
                @foreach ($tracking as $row)
                    <tr>
                        @php
                            $count = $count+($row->tracking_price*$row->count);
                        @endphp
                        <td>{{$row->tracking_price}}</td>
                        <td>{{$row->count}}</td>
                        <td>{{number_format($row->tracking_price*$row->count, '0','.',',').' VND'}}</td>
                    </tr>
                @endforeach
                @php
                    $afftervat = $count*100/108;
                    $vat = $count - $afftervat
                @endphp
                    <tr class="text-center">
                        <td colspan="3">Giá chưa tính thuế: {{number_format($afftervat, '0', '.',',').' VND'}}</td>
                    </tr>

                    <tr class="text-center">
                        <td colspan="3">VAT: {{number_format($vat, '0', '.',',').' VND'}}</td>
                    </tr>
                   
                    <tr class="text-center">
                        <td colspan="3">Tổng cộng (Đã tính thuế): {{number_format($count, '0', '.',',').' VND'}}</td>
                    </tr>
            </tbody>
        </table>

        @if(!$company)
        <div class="row mb-3 mt-3">
            <div class="card col-6 offset-3">
                <div class="card-header">
                    <h2>Nhập thông tin công ty</h2>
                </div>
                <div class="card-body">
                    <form action="{{URL::to('/create-company-info')}}" method="post">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="company_name">Tên công ty:</label>
                            <div class="col">
                                <input type="text" placeholder="" class="form-control" name="company_name" id="company_name">
                                @error('company_name')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-3">
                            <label for="company_tax">Mã số thuế:</label>
                            <div class="col">
                                <input type="text" placeholder="" class="form-control" name="company_tax" id="company_tax">
                                @error('company_tax')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-3">
                            <label for="company_address">Địa chỉ:</label>
                            <div class="col">
                                <input type="text" placeholder="" class="form-control" name="company_address" id="company_address">
                                @error('company_address')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-3">
                            <label for="comany_email">Email nhận hóa đơn:</label>
                            <div class="col">
                                <input type="email" placeholder="" class="form-control" name="company_email" id="company_email">
                                @error('company_email')
                                    <label class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-3">
                            <div class="col-1">
                                <input type="checkbox" class="form-check" name="agree" id="agree">
                            </div>
                            <div class="col">
                                <label for="agree" class="row">Tất cả thông tin đều chính xác và đúng sự thật</label>
                                @error('agree')
                                    <label for="agree" class="text-danger" class="row">{{$message}}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <div class="col-1"><button type="submit" class="btn btn-primary">Gửi</button></div>
                        </div>
                    </form>
                </div>
            </div>
            
            
        </div>
        @else
        <h3>thông tin xuất hóa đơn</h3>
        <div class="row">
            <div class="row mb-3">
                <div class="col-2">Tên công ty</div>
                <div class="col">{{$company->company_name}}</div>
            </div>
            <div class="row mb-3">
                <div class="col-2">Địa chỉ</div>
                <div class="col">{{$company->company_address}}</div>
            </div>
            <div class="row mb-3">
                <div class="col-2">Mã số thuế</div>
                <div class="col">{{$company->company_tax}}</div>
            </div>
            <div class="row mb-3">
                <div class="col-2">Email công ty</div>
                <div class="col">{{$company->company_email}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-1"><a href="{{URL::to('/export-vat')}}" class="btn btn-primary">Xuất</a></div>
        </div>
        @endif
    
       
    </div>
    @endif
@endsection