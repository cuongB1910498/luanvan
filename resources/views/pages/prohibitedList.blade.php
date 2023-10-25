@extends('welcome')
@section('content')
    <div class="row mb-3 mt-3">
        <div class="col-sm-8 col-12 offset-sm-2">
            <img src="{{asset('/public/frontend/images/prohibited_list.PNG')}}" alt="" width="100%">
        </div>
        <div class="">
            <table class="table table-light table-striped">
                <thead>
                    <th>STT</th>
                    <th>Mô Tả</th>
                </thead>
    
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Các chất ma tuý (bao gồm cả tiền chất và các chất hoá học tham gia vào quá trình chế tạo các chất ma tuý, kể cả các chất dùng trong y tế và nghiên cứu khoa học), các chất kích thích thần kinh.</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Vũ khí đạn dược quân trang, quân dụng, phương tiện kỹ thuật chuyên dùng của các lực lượng vũ trang.</td>
                    </tr>
                    
                    <tr>
                        <td>3</td>
                        <td>Vật sắc nhọn, vũ khí thô sơ: dao găm, mã tấu, thương, kiếm, mác,…; vũ khí thể thao; công cụ hỗ trợ và vũ khí khác có tính năng, tác dụng tương tự</td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Các loại ấn phẩm, tài liệu, hiện vật có nội dung kích động, gây mất an ninh, phá hoại đoàn kết dân tộc, chống phá Nhà nước Cộng hoà xã hội chủ nghĩa Việt Nam 
                            (bao gồm nhưng không giới hạn: tài liệu, hiện vật, bản đồ không thể hiện rõ ràng, 
                            chính xác, làm sai lệch, xuyên tạc sự toàn vẹn, thống nhất của chủ quyền, lãnh thổ nước Cộng hòa xã hội chủ nghĩa Việt Nam, …).</td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Vật, chất dễ nổ, dễ cháy, chất độc, chất phóng xạ, vi trùng dịch bệnh (kể cả các chất dùng trong y tế và nghiên cứu khoa học), và các chất gây nguy hiểm hoặc làm mất vệ sinh, gây ô nhiễm môi trường.</td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>Các vật, tài liệu phản động, đồi truỵ, mê tín dị đoan, trái đạo đức xã hội, trái thuần phong mỹ tục của Việt Nam hoặc có hại tới giáo dục thẩm mỹ, nhân cách.</td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>Nguyên liệu thuốc lá, sản phẩm thuốc lá (thuốc cỏ, thuốc lá điếu, xì gà, thuốc lá sợi, thuốc lào, thuốc lá điện tử,…) và các dạng thuốc lá thành phẩm khác nhập lậu.</td>
                    </tr>

                    <tr>
                        <td>8</td>
                        <td>Hóa chất độc hại: Xịt hơi cay, nước tẩy chứa hàm lượng axit cao,…; thuốc thú y, thuốc bảo vệ thực vật cấm hoặc chưa được phép sử dụng tại Việt Nam.</td>
                    </tr>

                    <tr>
                        <td>9</td>
                        <td>Pháo các loại, bao gồm nhưng không giới hạn: pháo hoa, pháo nổ, pháo bông, pháo sáng,….</td>
                    </tr>

                    <tr>
                        <td>10</td>
                        <td>Sinh vật sống; thực vật rừng, nguy cấp, quý hiếm; thực phẩm yêu cầu bảo quản.</td>
                    </tr>

                    <tr>
                        <td>11</td>
                        <td>Tiền Việt Nam, nước ngoài và các giấy tờ có giá trị như tiền; hóa đơn GTGT; giấy tờ không thể cấp lại; bản gốc các giấy tờ chứng thực cá nhân, văn bằng, chứng chỉ,….</td>
                    </tr>
                    
                    <tr>
                        <td>12</td>
                        <td> Các vật phẩm, hàng hóa khác mà pháp luật của Việt Nam quy định cấm lưu thông, xuất khẩu, nhập khẩu, cấm nhập vào nước nhận, cấm vận chuyển bằng đường bưu chính theo quy định của pháp luật Việt Nam, điều ước quốc tế mà Cộng hòa xã hội chủ nghĩa Việt Nam là thành viên tại từng thời điểm.</td>
                    </tr>

                    <tr>
                        <td colspan="2">còn tiếp...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
@endsection