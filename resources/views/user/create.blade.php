@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">新建用户</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>用户管理
                </li>
                <li class="active">
                    <strong>新建用户</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/user') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">用户名</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="email">登录邮箱</label>

                            <div class="col-sm-10">
                                @if ($errors->has('email'))
                                    <label class="control-label">{{ $errors->first('email') }}</label>
                                @endif
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                            </div>

                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label" for="password">密码</label>

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

                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户组</label>

                            <div class="col-sm-10">
                                <select name="type" class="form-control">
                                    @foreach(\App\User::$group as $v => $k)
                                        <option value="{{ $v }}">{{ $k }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>

                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="1" selected="selected">正常</option>
                                    <option value="0">停用</option>
                                </select>
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