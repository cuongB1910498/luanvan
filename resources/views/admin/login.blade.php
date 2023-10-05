<!DOCTYPE html>

<head>
    <title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Login :: w3layouts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="" />
    <!-- bootstraps 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href={{asset("public/frontend/css/login.css")}}>

    {{-- captcha google --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        .g-recaptcha {
            width: 50%;
            margin: 0px auto;
        }

        .error{
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-12 col-md-6 col-sm-6 m-auto">
                <div class="card">
                    <div class="card-header text-center bg-info">
                        <h3>ADMIN LOGIN</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{URL::to("/admin-login-process")}}" method="post" id="login-form">
                            {{ csrf_field() }}

                            <p style="color: red" class="text-center">{{Session('msg')}}</p>
                            
                            <div class="form-group row text-center">
								<div class="mb-3">
									<input type="text" class="form-control text-center" id="username" name="username" placeholder="USERNAME"/>
                                    @error('username')
                                        <label class="error">{{$message}}</label>
                                    @enderror
								</div>
							</div>

                            <div class="form-group row text-center mb-3 mt-3">
								<div class=" ">
									<input type="password" class="form-control text-center" id="password" name="password" placeholder="PASSWORD" />
                                    @error('password')
                                        <label class="error">{{$message}}</label>
                                    @enderror
								</div>
							</div>
                            
                            <div class="form-group mb-3 row">
                                <div class="col-lg-4 offset-lg-2">
                                    <div class="captcha">
                                        <span class="me-2">{!! captcha_img() !!}</span>
                                        <button type ="button" class="btn btn-danger reload" id="reload">&#x21bb;</button>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" placeholder="Enter captcha here ..." class="form-control" name="captcha">
                                    @error('captcha')
                                        <label class="error">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary mb-3">SUBMIT</button>
                            </div>
                            
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src={{asset("public/frontend/js/jquery.validate.js")}}></script>

    <script>
        $(document).ready(function(){
            $('#login-form').validate({
                rules: {
                    'username': {required:true},
                    'password': {required:true},

                },
                messages:{
                    'username': {required:'Bạn chưa điền tên đăng nhập'},
                    'password': {required:'Bạn chưa điền mật khẩu'}
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
        })
        
    </script>
</body>

</html>
