
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>页面剧情</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="" />

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <meta property="og:description" content=""/>
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Animate.css -->
    <link rel="stylesheet" href="css/animate_1.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="css/icomoon_1.css">
    <!-- Simple Line Icons -->
    <link rel="stylesheet" href="css/simple-line-icons_1.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl.carousel.min_1.css">
    <link rel="stylesheet" href="css/owl.theme.default.min_1.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap_1.css">

    <link rel="stylesheet" href="css/style_1_2.css">

    <!-- Styleswitcher ( This style is for demo purposes only, you may delete this anytime. ) -->
    <link rel="stylesheet" id="theme-switch" href="css/style_1_2.css">
    <!-- End demo purposes only -->

    <!-- Modernizr JS -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="ukagaka/css/style.css" media="all" />
</head>
<script>
    var pet_missionState = 1;
</script>
<body id="ios">

<header role="banner" id="fh5co-header">
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
                <a class="navbar-brand" href="/">伪春菜</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('/') }}"><span>网站首页</span></a></li>
                    <li class="active"><a href="{{ url('/plot') }}"><span>页面剧情</span></a></li>
                    @if (Auth::user())
                        <li><a target="_blank" href="{{ url('/pet') }}" >{{ Auth::user()->name }}</a></li>
                        <li><a href="{{ url('/logout') }}">退出</a></li>
                    @else
                        <li><a href="{{ url('/login') }}" class="btn btn-primary btn-sm">登录</a></li>
                        <li><a href="{{ url('/register') }}" class="btn btn-primary btn-sm">注册</a></li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
<div id="fh5co-press" data-section="press">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heading text-center">
                <h2 class="single-animate animate-press-1">剧情流程</h2>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 subtext single-animate animate-press-2">
                        <h3></h3>
                        <p><span class="btn btn-primary btn-sm" target="_blank">进入本页面已经打开剧情，可以点击选项继续</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>
<!-- Waypoints -->
<script src="js/jquery.waypoints.min.js"></script>
<!-- Owl Carousel -->
<script src="js/owl.carousel.min.js"></script>

<!-- For demo purposes only styleswitcher ( You may delete this anytime ) -->
<script src="js/jquery.style.switcher.js"></script>
<script>
    $(function(){
        $('#colour-variations ul').styleSwitcher({
            defaultThemeId: 'theme-switch',
            hasPreview: false,
            cookie: {
                expires: 30,
                isManagingLoad: true
            }
        });
        $('.option-toggle').click(function() {
            $('#colour-variations').toggleClass('sleep');
        });
    });
</script>
<!-- End demo purposes only -->

<!-- Main JS (Do not remove) -->
<script src="js/main.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script src="js/jquery.fancybox.js" type="text/javascript"></script>
<link href="css/jquery.fancybox_1.css" m edia="screen" rel="stylesheet" type="text/css" />
<!-- fancybox_app -->
<script src="js/fancybox_app.js" type="text/javascript"></script>
<!-- Add mousewheel plugin (this is optional) -->
<script src="js/jquery.mousewheel-3.0.6.pack.js" type="text/javascript"></script>
<script src="ukagaka/js/common.js"></script>
</html>
