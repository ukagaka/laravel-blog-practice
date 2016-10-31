@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">新建分类</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>分类管理
                </li>
                <li class="active">
                    <strong>新建分类</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/recomgro') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="title">分类名称</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title">
                        </div>
                    </div>

                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="rec_sum">最大保存数</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="rec_sum">
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