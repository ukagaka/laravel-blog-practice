
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="伪春菜后台" />
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

    <script src="/assets/js/jquery-1.11.1.min.js"></script>


</head>
<body class="page-body login-page login-light">


<div class="login-container">

    <div class="row">

        <div class="col-sm-6">



            <!-- Add class "fade-in-effect" for login form effect -->
            <form role="form" method="POST" action="{{ url('/register') }}" class="login-form fade-in-effect in">
                {{ csrf_field() }}
                <div class="login-header">
                    <img src="assets/images/logo-white-bg.png" alt="" width="80" />
                    <span>注册</span>

                </div>

                <div class="form-group">
                    <label class="control-label" for="name">昵称</label>
                    <input id="name" type="email" class="form-control {{ $errors->has('name') ? 'error' : '' }}"  name="name" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('name'))
                        <label class="error" for="inputError">{{ $errors->first('name') }}</label>
                    @endif
                </div>


                <div class="form-group">
                    <label class="control-label" for="email">邮箱</label>
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'error' : '' }}"  name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <label class="error" for="inputError">{{ $errors->first('email') }}</label>
                    @endif
                </div>

                <div class="form-group">
                    <label class="control-label" for="password">密码</label>
                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'error' : '' }}" name="password"  required>
                    @if ($errors->has('password'))
                        <label class="error" for="inputError">{{ $errors->first('password') }}</label>
                    @endif
                </div>

                <div class="form-group">
                    <label class="control-label" for="password">确认密码</label>
                    <input id="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? 'error' : '' }}" name="password_confirmation"  required>
                    @if ($errors->has('password_confirmation'))
                        <label class="error" for="inputError">{{ $errors->first('password_confirmation') }}</label>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary  btn-block text-left">
                        <i class="fa-lock"></i>
                        Reg In
                    </button>
                </div>

                <div class="login-footer">
                    <input type="checkbox" name="remember"> 记住密码
                </div>

            </form>

        </div>

    </div>

</div>



<!-- Bottom Scripts -->
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/TweenMax.min.js"></script>
<script src="/assets/js/resizeable.js"></script>
<script src="/assets/js/joinable.js"></script>
<script src="/assets/js/xenon-api.js"></script>
<script src="/assets/js/xenon-toggles.js"></script>
<script src="/assets/js/jquery-validate/jquery.validate.min.js"></script>
<script src="/assets/js/toastr/toastr.min.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="/assets/js/xenon-custom.js"></script>

</body>
</html>
