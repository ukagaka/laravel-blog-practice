<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Xenon Boostrap Admin Panel" />
    <meta name="author" content="" />

    <title>伪春菜后台</title>

    <link rel="stylesheet" href="/assets/css/fonts/linecons/css/linecons.css">
    <link rel="stylesheet" href="/assets/css/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/xenon-core.css">
    <link rel="stylesheet" href="/assets/css/xenon-forms.css">
    <link rel="stylesheet" href="/assets/css/xenon-components.css">
    <link rel="stylesheet" href="/assets/css/xenon-skins.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/css/editor.css">
    @yield('css')
    <script src="/assets/js/jquery-1.11.1.min.js"></script>

</head>
<body class="page-body">


<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
    <!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
    <!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
    <div class="sidebar-menu toggle-others fixed">

        <div class="sidebar-menu-inner">

            <header class="logo-env">
                <div class="logo">
                    <a href="{{ url('/') }}" class="logo-expanded">
                        <img src="/assets/images/logo-white-bg@2x.png" width="80" alt="">
                    </a>
                </div>
                <div class="settings-icon">
                    <a href="{{ url('/') }}">
                        <i class="fa-home"></i>
                    </a>
                </div>

            </header>


            <ul id="main-menu" class="main-menu">
                <li @if(Request::is('pet') || Request::is('pet/info/*'))class="active"@endif>
                    <a href="{{ url('/pet') }}">
                        <i class="fa-columns"></i>
                        <span class="title">伪春菜管理</span>
                    </a>
                </li>

                <li @if(Request::is('user/info'))class="active"@endif >
                    <a href="{{ url('user/info') }}">
                        <i class="fa-hospital-o"></i>
                        <span class="title">个人设置</span>
                    </a>
                </li>

                @if(Auth::user()->group_id == 1)
                    <li @if(Request::is('pet/all'))class="active"@endif>
                        <a href="{{ url('/pet/all') }}">
                            <i class="fa-columns"></i>
                            <span class="title">伪春菜</span>
                        </a>
                    </li>
                    <li @if(Request::is('pet/create'))class="active"@endif >
                        <a href="{{ url('pet/create') }}">
                            <i class="fa-hospital-o"></i>
                            <span class="title">新建伪春菜</span>
                        </a>
                    </li>
                    <li @if(Request::is('event') || Request::is('event/edit/*'))class="active"@endif>
                        <a href="{{ url('/event') }}">
                            <i class="fa-bell-o"></i>
                            <span class="title">通告列表</span>
                        </a>
                    </li>
                    <li @if(Request::is('event/create'))class="active"@endif>
                        <a href="{{ url('/event/create') }}">
                            <i class="fa-comments-o"></i>
                            <span class="title">新建通告</span>
                        </a>
                    </li>
                    <li @if(Request::is('user') || Request::is('user/edit/*'))class="active"@endif>
                        <a href="{{ url('/user') }}">
                            <i class="fa-user"></i>
                            <span class="title">管理员列表</span>
                        </a>
                    </li>

                @endif
            </ul>

        </div>

    </div>

    <div class="main-content">

        <!-- User Info, Notifications and Menu Bar -->
        <nav class="navbar user-info-navbar" role="navigation">

            <!-- Left links for user info navbar -->
            <ul class="user-info-menu left-links list-inline list-unstyled">

                <li class="hidden-sm hidden-xs">
                    <a href="#" data-toggle="sidebar">
                        <i class="fa-bars"></i>
                    </a>
                </li>

            </ul>


            <!-- Right links for user info navbar -->
            <ul class="user-info-menu right-links list-inline list-unstyled">

                <li class="dropdown user-profile">
                    <a href="#" data-toggle="dropdown">
                        <img src="/assets/images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
                        <span>
								{{ Auth::user()->name }}
                            <i class="fa-angle-down"></i>
							</span>
                    </a>

                    <ul class="dropdown-menu user-profile-menu list-unstyled">
                        <li>
                            <a href="{{ url('/reset') }}">
                                <i class="fa-wrench"></i>
                                修改密码
                            </a>
                        </li>
                        <li class="last">
                            <a href="{{ url('/logout') }}">
                                <i class="fa-lock"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

        </nav>
        @yield('content')

        <footer class="main-footer sticky footer-type-1">

            <div class="footer-inner">

                <!-- Add your copyright text here -->
                <div class="footer-text">
                </div>


                <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                <div class="go-up">

                    <a href="#" rel="go-top">
                        <i class="fa-angle-up"></i>
                    </a>

                </div>

            </div>

        </footer>
    </div>



</div>

<!-- Bottom Scripts -->
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/TweenMax.min.js"></script>
<script src="/assets/js/resizeable.js"></script>
<script src="/assets/js/joinable.js"></script>
<script src="/assets/js/xenon-api.js"></script>
<script src="/assets/js/xenon-toggles.js"></script>
<script src="http://static.2258.com/guba/plugin/kindeditor-4.1.11/kindeditor-all-min.js"></script>
<script src="http://static.2258.com/guba/plugin/plupload-2.1.9/js/plupload.full.min.js"></script>
<script src="/assets/js/editor.js"></script>

<!-- JavaScripts initializations and stuff -->
<script src="/assets/js/xenon-custom.js"></script>
@yield('js')
</body>
</html>