<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>网站首页</title>
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
    <link rel="stylesheet" href="css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="css/icomoon.css">
    <!-- Simple Line Icons -->
    <link rel="stylesheet" href="css/simple-line-icons.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <link rel="stylesheet" href="css/style_1_1.css">

    <!-- Styleswitcher ( This style is for demo purposes only, you may delete this anytime. ) -->
    <link rel="stylesheet" id="theme-switch" href="css/style_1_1.css">
    <!-- End demo purposes only -->

    <!-- Modernizr JS -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="js/respond.min.js"></script>
    <![endif]-->


    <link rel="stylesheet" type="text/css" href="ukagaka/css/style.css" media="all" />


</head>
<body>

<header role="banner" id="fh5co-header">
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
                <a class="navbar-brand" href="/">伪春菜</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="#" data-nav-section="home"><span>网站首页</span></a></li>
                    <li><a href="#" data-nav-section="services"><span>产品介绍</span></a></li>
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
<div id="slider" data-section="home">
    <div class="owl-carousel owl-carousel-fullwidth">

        <div class="item" style="background-image:url(images/hn0fqc.jpg)">
            <div class="overlay"></div>
            <div class="container" style="position: relative;">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <div class="fh5co-owl-text-wrap">
                            <div class="fh5co-owl-text">
                                <h1 class="fh5co-lead to-animate">二次元萌宠</h1>
                                <h2 class="fh5co-sub-lead to-animate">web伪春菜，一种网页版的萌宠。</h2>
                                <p class="to-animate-2">
                                    <a href="#" class="btn btn-primary btn-lg" data-nav-section="pricing">现在马上联系，获得技术支持</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="item item3" style="background-image:url(images/0i6fae.jpg)">
            <div class="container" style="position: relative;">
                <div class="row">
                    <div class="col-md-7 col-md-push-1 col-md-push-5 col-sm-7 col-sm-push-1 col-sm-push-5">
                        <div class="fh5co-owl-text-wrap">
                            <div class="fh5co-owl-text">
                                <h1 class="fh5co-lead to-animate">二次元萌宠</h1>
                                <h2 class="fh5co-sub-lead to-animate">web伪春菜，一种网页版的萌宠。</h2>
                                <p class="to-animate-2">
                                    <a href="#" class="btn btn-primary btn-lg" data-nav-section="pricing">现在马上联系，获得技术支持</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="copyrights">Collect from <a href="#" >伪春菜</a></div>

<div id="fh5co-our-services" data-section="services">
    <div class="container">
        <div class="row row-bottom-padded-sm">
            <div class="col-md-12 section-heading text-center">
                <h2 class="to-animate">产品介绍</h2>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 to-animate">
                        <h3>web伪春菜，就是一个网页端的小程式，开发的目的就是能为主人们处理电脑大大小小的事情，包括报时、聊天、对时、关心主人的身体等等，有如此多魅力这就是伪春菜吸引人的地方。</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="box to-animate">
                    <div class="icon colored-5"><span><i class="icon-rocket"></i></span></div>
                    <h3>运送物资</h3>
                    <p>每日任务可以通过完成每日任务获取到物资</p>
                </div>
                <div class="box to-animate">
                    <div class="icon colored-4"><span><i class="icon-heart"></i></span></div>
                    <h3>问候</h3>
                    <p>贴心提醒用户吃饭、睡觉</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box to-animate">
                    <div class="icon colored-2"><span><i class="icon-screen-desktop"></i></span></div>
                    <h3>显示三围</h3>
                    <p>显示伪春菜的三围状态。包括等级，状态，活力，饥饿值等，用户后期的活动</p>
                </div>
                <div class="box to-animate">
                    <div class="icon colored-1"><span><i class="icon-mustache"></i></span></div>
                    <h3>周公解梦</h3>
                    <p>输入关键字，进行解梦</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box to-animate">
                    <div class="icon colored-3"><span><i class="icon-user"></i></span></div>
                    <h3>触发试剧情</h3>
                    <p>对话试剧情，对于特定页面进行有几率触发剧情</p>
                </div>
                <div class="box to-animate">
                    <div class="icon colored-6"><span><i class="icon-eye"></i></span></div>
                    <h3>星座运程/老黄历</h3>
                    <p>查看星座今天的运程和老黄历</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="fh5co-testimonials" data-section="testimonials">
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
<link href="css/jquery.fancybox.css" media="screen" rel="stylesheet" type="text/css" />
<!-- fancybox_app -->
<script src="js/fancybox_app.js" type="text/javascript"></script>
<!-- Add mousewheel plugin (this is optional) -->
<script src="js/jquery.mousewheel-3.0.6.pack.js" type="text/javascript"></script>

<script src="ukagaka/js/common.js"></script>
</body>
</html>
