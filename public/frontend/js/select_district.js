$(document).ready(function() {
    $('#province_sent').on('change', function() {
    var selectedValue = $(this).val();
    //alert(selectedValue);
    $.ajax({
        url: 'select-province',
          method: 'GET',
          data: {
            selectedValue: selectedValue
          },
        success: function(data) {
            var district_sent =$('#district_sent');
            district_sent.empty();
            $.each(data, function(key, district) {
                $('#district_sent').append($('<option>', {
                    value: district.id_district,
                    text: district.district_name
                }));
            });
        },
        error: function() {
          alert('Đã có lỗi xảy ra.');
        }
      });
    });

    $('#province_receive').on('change', function() {
    var selectedValue = $(this).val();
    //alert(selectedValue);
    $.ajax({
        url: 'select-province',
        method: 'GET',
        data: {
            selectedValue: selectedValue
          },
        success: function(data) {
            var district_sent =$('#district_receive');
            district_sent.empty();
            $.each(data, function(key, district) {
                $('#district_receive').append($('<option>', {
                    value: district.id_district,
                    text: district.district_name
                }));
            });
        },
        error: function() {
          alert('Đã có lỗi xảy ra.');
        }
      });
    });

    
    
});
function formatCurrency(number) {
    return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

function cal_price(){
    var address  = document.getElementById("id_address");
    if(address!= null){
        var addressOption = address.options[address.selectedIndex];
        var addressText = addressOption.text;
        var partaddresText = addressText.split(",");
        var province_sent = partaddresText[partaddresText.length-1];

        var province = document.getElementById("province_receive");
        var provinceOption = province.options[province.selectedIndex];
        var province_receive = provinceOption.text;
    }else{
        var province_sent = document.getElementById("province_sent").value;
        var province_receive = document.getElementById("province_receive").value;
    }
    
    //alert(province_sent);
    
    
    //alert(province_receive);
   
    
    
    var getinput = document.getElementById("weight").value;
    var get_extra_service = document.getElementById("id_extra_service").value;
    var split_es = get_extra_service.split('-');
    var extra_service = parseInt(split_es[0]);
    var gram = parseInt(getinput)
    if(province_receive == province_sent){
        //document.getElementById("result").textContent = province_receive+' - '+province_sent;
        if(gram <= 500){
            price = 20000 + extra_service;
            document.getElementById("result").textContent = formatCurrency(price);
        }else if(gram > 500 && gram <= 1000){
            price = 25000 + extra_service;
            document.getElementById("result").textContent = formatCurrency(price);
        }else if( gram > 1000 && gram <=3000){
            
            price = 30000 + extra_service;
            document.getElementById("result").textContent = formatCurrency(price);
        }else if(gram > 3000){
            price = 30000 + (gram - 3000)*15 + extra_service
            document.getElementById("result").textContent = formatCurrency(price);
        }
        else{
            document.getElementById("result").textContent = "Chưa nhập hoặc Lỗi nhập liệu";
        }
    }else{
        //document.getElementById("result").textContent = province_receive+province_sent;
        if(gram <= 500){
            price =25000 + extra_service;
            document.getElementById("result").textContent = formatCurrency(price);
        }else if(gram > 500 && gram <= 1000){
            
            price =30000 + extra_service;
            document.getElementById("result").textContent = formatCurrency(price);
        }else if( gram > 1000 && gram <=3000){
            
            price =40000 + extra_service;
            document.getElementById("result").textContent = formatCurrency(price);
        }else if(gram > 3000){
            price =40000 + (gram - 3000)*15 + extra_service
            document.getElementById("result").textContent = formatCurrency(price);
        }
        else{
            document.getElementById("result").textContent = "Chưa nhập hoặc Lỗi nhập liệu";
        }
    }
    
}