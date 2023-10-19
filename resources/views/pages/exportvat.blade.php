<h1>Thông tin hóa đơn</h1>
<table>
    <thead>
    <tr>
        <th>Giá đơn hàng</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        @php
            $count = 0;
            $count = $count+($row->tracking_price*$row->count);
        @endphp
        <tr>
            <td>{{ $row->tracking_price }}</td>
            <td>{{ $row->count }}</td>
            <td>{{ $row->total }}</td>
        </tr>
    @endforeach 
    @php
        $afftervat = $count*100/108;
        $vat = $count - $afftervat
    @endphp
        <tr>
            <td colspan="3">Giá chưa tính thuế: {{number_format($afftervat, '0', '.',',').' VND'}}</td>
        </tr>

        <tr>
            <td colspan="3">VAT: {{number_format($vat, '0', '.',',').' VND'}}</td>
        </tr>
    
        <tr>
            <td colspan="3">Tổng cộng (Đã tính thuế): {{number_format($count, '0', '.',',').' VND'}}</td>
        </tr>
    </tbody>
</table>
<h1>Thông tin bên mua</h1>
<p>Tên công ty: {{$additionalInfo->company_name}}</p>
<p>Mã số thuế: {{$additionalInfo->company_tax}}</p>
<p>Địa chỉ công ty: {{ $additionalInfo->company_address }}</p>
<p>Email công ty: {{$additionalInfo->company_email}}</p>