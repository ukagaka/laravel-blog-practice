@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">个人设置</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/user/update') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">用户名</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="email">登录邮箱</label>

                            <div class="col-sm-10">
                                <input type="text" name="email" value="{{ $data->email }}" class="form-control" disabled="">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户组</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" value="{{ \App\User::$group[$data->group_id] }}" class="form-control" disabled="">
                            </div>

                        </div>

                        <div class="form-group-separator"></div>

                        <input type="hidden" value="{{ $data->id }}" name="id">
                        <button type="submit" class="btn btn-info btn-single pull-right">提交</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection