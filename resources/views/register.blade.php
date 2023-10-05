<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<title>Đăng Ký Thành Viên</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"/>
	<style>
		.error{
			color: red;
		}
		
		.card-header{
   		 	background-color: #30A2FF;
		}

		h3{
    		color: #FFE7A0;
		}

	</style>
</head>
<body>
	<div class="container mt-3 mb-5 pt-4">
		<div class="row">
			<div class="col-sm-8 offset-sm-2">
				<div class="card">
					<div class="card-header text-center">
						<h3>ĐĂNG KÝ THÀNH VIÊN</h3>
					</div>
					<div class="card-body">
						<form id="signupForm" method="post" class="form-horizontal" action={{URL::to('/register')}}>
							{{{ csrf_field() }}}
							<div class="form-group row">
								<label class="col-sm-4 col-form-label" for="firstname">Tên của bạn</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Tên của bạn" value="{{ old('firstname') }}" autocomplete="firstname"/>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label" for="lastname">Họ của bạn</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Họ của bạn" value="{{ old('lastname') }}" autocomplete="lastname"/>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label" for="username">Tên đăng nhập</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" />
								</div>
								<?php
									$usn_check = Session::get('usn_check');
									if($usn_check){
								?>
								<label class="error"><?php echo $usn_check ?></label>
								<?php
									Session::put('usn_check', null);
									}
								?>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label" for="email">Hộp thư điện tử</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="email" name="email" placeholder="Hộp thư điện tử" value="{{ old('email') }}" autocomplete="email"/>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label" for="phome">Số điện thoại</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="{{old('phone')}}" autocomplete="phone"/>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label" for="password">Mật khẩu</label>
								<div class="col-sm-5">
									<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" />
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label" for="confirm_password">Nhập lại mật khẩu</label>
								<div class="col-sm-5">
									<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" />
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-4 captcha">
									<span class="me-2">{!! captcha_img() !!}</span>
                                    <button type ="button" class="btn btn-danger reload" id="reload">&#x21bb;</button>
								</div>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="captcha" name="captcha" placeholder="Nhập captcha tại đây" />
									@error('captcha')
                                        <label class="error">{{$message}}</label>
                                    @enderror
								</div>
							</div>

							<div class="form-group form-check">
								<div class="col-sm-5 offset-sm-4">
									<input class="form-check-input" type="checkbox" id="agree" name="agree" value="agree" />
									<label class="form-check-label" for="agree">Đồng ý các quy định của chúng tôi</label>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-5 offset-sm-4">
									<button type="submit" class="btn btn-primary" name="signup" value="Sign up">Đăng ký</button>
								</div>
							</div>

							<div class="text-right mt-3">
								<div>
                                    <a href={{URL::to('/login')}} class="card-link">Đã có tài khoản? Đến đăng nhập</a>
                                </div>
							</div>

						</form>
					</div>
				</div>
			</div> <!-- Cột nội dung -->
		</div> <!-- Dòng nội dung -->
	</div> <!-- Container -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src={{asset("public/frontend/js/jquery.validate.js")}}></script>

	<script type="text/javascript">
		$(document).ready(function () {
			$("#signupForm").validate({
				rules: {
					firstname: "required",
					lastname: "required",
					username: { required: true, minlength: 2},
					password: { required: true, minlength: 5},
					confirm_password: { required: true, minlength: 5, equalTo: "#password"},
					email: { required: true, email: true},
					phone: { required: true, number: true},
					agree: "required",
					captcha: "required",
				},
				messages: {
					firstname: "bạn chưa nhập vào họ của bạn",
					lastname: "bạn chưa nhập vào tên của bạn",
					username: {
						required: "Bạn chưa nhập vào tên đăng nhập",
						minlength: "Tên đăng nhập phải có ít nhất 2 ký tự"
					},
					password: {
						required: "Bạn chưa nhập mật khẩu",
						minlength: "Mật khẩu phải có ít nhất 5 ký tự"
					},
					confirm_password: {
						required: "Bạn chưa nhập mật khẩu",
						minlength: "Mật khẩu phải có ít nhất 5 ký tự",
						equalTo: "Mật khẩu không trùng khớp với mật khẩu đã nhập"
					},
					email: "Hộp thư điên tử không hợp lệ",
					phone: { required: "Bạn chưa nhập số điện thoại", number: "Bạn chỉ được nhập số"},
					agree: "Bạn phải đồng ý với các qui định của chúng tôi",
					captcha: "Bạn chưa nhập captcha!",
				},
				ErrorElement: "div",
				ErrorPlacement: function (error, element) {
					error.addClass("invalid-feedback");
					if(element.prop("type") === "checkbox") {
						error.inserAfter(element.siblings("label"));
					}else {
						error.inserAfter(element);
					}
				},
				highlight: function (element, errorClass, validClass) {
					$(element).addClass("is-invalid").removeClass("is-valid");
				},
				unhighlight: function (element, errorClass, validClass) {
					$(element).addClass("is-valid").removeClass("is-invalid");
				}
			});

			$('#reload').click(function(){
                $.ajax({
                    type:'GET',
                    url:'reload-captcha',
                    success:function(data){
                        $(".captcha span").html(data.captcha)
                    }
                });
            });
		});


		
	</script>
</body>
</html>
