$(document).ready(function () {
    $('#tracking-form').submit(function (e) {
        e.preventDefault();

        // Lấy dữ liệu từ trường textarea
        var trackingData = $('textarea[name="tracking"]').val();

        // Gửi dữ liệu bằng Ajax
        $.ajax({
            url: 'process-tracking',
            type: 'POST',
            data: { 
                _token: $('meta[name="csrf-token"]').attr('content'),
                tracking: trackingData 
            },
            dataType: 'json',
            success: function (data) {
                // Xử lý kết quả JSON
                displayResults(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    function displayResults(data) {
        var resultsContainer = $('#results');
        resultsContainer.empty();

        // Duyệt qua kết quả JSON và hiển thị từng đơn
        $.each(data, function (trackingId, items) {
            var trackingResult = $('<div>');

            if (items.length === 0) {
                trackingResult.html(trackingId + ': Không có thông tin.');
            } else {
                trackingResult.append(trackingId + ':<ul>');
                $.each(items, function (index, item) {
                    trackingResult.append('<li>' + item.note + '</li>');
                });
                trackingResult.append('</ul>');
            }

            resultsContainer.append(trackingResult);
        });
    }
});