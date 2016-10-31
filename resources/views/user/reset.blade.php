@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">修改密码</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>用户管理
                </li>
                <li class="active">
                    <strong>修改密码</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/reset') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="panel-body">

                        <div class="form-group {{ $errors->has('oldpassword') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="password">原始密码</label>

                            <div class="col-sm-10">
                                @if ($errors->has('oldpassword'))
                                    <label class="control-label">{{ $errors->first('oldpassword') }}</label>
                                @endif
                                <input type="password" class="form-control" name="oldpassword">
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="password">新密码</label>

                            <div class="col-sm-10">
                                @if ($errors->has('password'))
                                    <label class="control-label">{{ $errors->first('password') }}</label>
                                @endif
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="password_confirmation">确认密码</label>

                            <div class="col-sm-10">
                                @if ($errors->has('password_confirmation'))
                                    <label class="control-label">{{ $errors->first('password_confirmation') }}</label>
                                @endif
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>
                        <button type="submit" class="btn btn-info btn-single pull-right">提交</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection