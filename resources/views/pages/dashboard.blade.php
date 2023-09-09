<!DOCTYPE html>

<head>
    <title>Thyn Express</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href={{asset('/public/backend/css/bootstrap.min.css')}}>
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href={{asset('/public/backend/css/style.css')}} rel='stylesheet' type='text/css' />
    <link href={{asset('/public/backend/css/style-responsive.css')}} rel="stylesheet" />
    <!-- font CSS -->
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href={{asset('/public/backend/css/font.css')}} type="text/css" />
    <link href={{asset("/public/backend/css/font-awesome.css")}} rel="stylesheet">
    <link rel="stylesheet" href={{asset('/public/backend/css/morris.css')}} type="text/css" />
    <!-- calendar -->
    <link rel="stylesheet" href={{asset('/public/backend/css/monthly.css')}}>
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src={{asset('/public/backend/js/jquery2.0.3.min.js')}}></script>
    <script src={{asset('/public/backend/js/raphael-min.js')}}></script>
    <script src={{asset('/public/backend/js/morris.js')}}></script>

    {{-- css frontend --}}
    <link rel="stylesheet" href="{{asset('/public/frontend/css/user.css')}}">
</head>

<body>
    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">
                <a href={{URL::to('/user')}} class="logo">
                    Tạo đơn 
                </a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>
            <!--logo end-->
            
            <div class="top-nav clearfix">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li>
                        <input type="text" class="form-control search" placeholder=" Search">
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src={{asset('public/backend/images/2.png')}}>
                            <span class="username">
                                <?php
                                    $name = Session::get('firstname');
                                    if($name){
                                        echo $name;
                                    }
                                ?>
                            </span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a class="active" href={{URL::to('/user')}}>
                                <i class="fa fa-dashboard"></i>
                                <span>Về trang chính</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="">
                                <i class="fa fa-book"></i>
                                <span>Quản lý đơn hàng</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{URL::to('/create-tracking')}}">Tạo đơn hàng</a></li>
                                <li><a href="{{URL::to('/list-tracking')}}">Xem đơn hàng</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="">
                                <i class="fa fa-user"></i>
                                <span>Quản lý tài khoản</span>
                            </a>
                            <ul class="sub">
                                <li><a href="">Cập nhật thông tin</a></li>
                                <li><a href="">Đổi mật khẩu</a></li>
                            </ul>
                        </li>
                         {{--<li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-th"></i>
                                <span>Xem báo cáo</span>
                            </a>
                            <ul class="sub">
                                <li><a href="basic_table.html"></a></li>
                                <li><a href="responsive_table.html">Responsive Table</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-tasks"></i>
                                <span>Form Components</span>
                            </a>
                            <ul class="sub">
                                <li><a href="form_component.html">Form Elements</a></li>
                                <li><a href="form_validation.html">Form Validation</a></li>
                                <li><a href="dropzone.html">Dropzone</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-envelope"></i>
                                <span>Mail </span>
                            </a>
                            <ul class="sub">
                                <li><a href="mail.html">Inbox</a></li>
                                <li><a href="mail_compose.html">Compose Mail</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class=" fa fa-bar-chart-o"></i>
                                <span>Charts</span>
                            </a>
                            <ul class="sub">
                                <li><a href="chartjs.html">Chart js</a></li>
                                <li><a href="flot_chart.html">Flot Charts</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class=" fa fa-bar-chart-o"></i>
                                <span>Maps</span>
                            </a>
                            <ul class="sub">
                                <li><a href="google_map.html">Google Map</a></li>
                                <li><a href="vector_map.html">Vector Map</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-glass"></i>
                                <span>Extra</span>
                            </a>
                            <ul class="sub">
                                <li><a href="gallery.html">Gallery</a></li>
                                <li><a href="404.html">404 Error</a></li>
                                <li><a href="registration.html">Registration</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="login.html">
                                <i class="fa fa-user"></i>
                                <span>Login Page</span>
                            </a>
                        </li> --}}
                    </ul>
                </div>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">

                @yield('user_content')

            </section>
            <!-- footer -->
            <div class="footer">
                <div class="wthree-copyright">
                    <p>© 2023 THYN express. All rights reserved</a>
                    </p>
                </div>
            </div>
            <!-- / footer -->
        </section>
        <!--main content end-->
    </section>
    <script src={{asset("public/backend/js/bootstrap.js")}}></script>
    <script src={{asset("public/backend/js/jquery.dcjqaccordion.2.7.js")}}></script>
    <script src={{asset("public/backend/js/scripts.js")}}></script>
    <script src={{asset("public/backend/js/jquery.slimscroll.js")}}></script>
    <script src={{asset("public/backend/js/jquery.nicescroll.js")}}></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
    <script src={{asset("public/backend/js/jquery.scrollTo.js")}}></script>
    <!-- morris JavaScript -->
    <script>
        $(document).ready(function() {
            //BOX BUTTON SHOW AND CLOSE
            jQuery('.small-graph-box').hover(function() {
                jQuery(this).find('.box-button').fadeIn('fast');
            }, function() {
                jQuery(this).find('.box-button').fadeOut('fast');
            });
            jQuery('.small-graph-box .box-close').click(function() {
                jQuery(this).closest('.small-graph-box').fadeOut(200);
                return false;
            });
        });
    </script>
    
    <?php
        $login_complete = Session::get('login_complete');
        if($login_complete){
            echo "<script>alert('đăng nhập thành công')</script>";
            Session::put('login_complete', null);
        }
    ?>
</body>

</html>
