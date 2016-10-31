@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">新建敏感词</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>敏感词管理
                </li>
                <li class="active">
                    <strong>新建敏感词</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/nowords') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="title">敏感词</label>

                            <div class="col-sm-10">
                                <textarea name="words" class="form-control" rows="20" cols="10"></textarea>
                                <p class="help-block">每个敏感字以回车进行分割</p>
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