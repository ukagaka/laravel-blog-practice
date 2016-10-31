@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">新建帖子</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>帖子管理
                </li>
                <li class="active">
                    <strong>新建帖子</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/post') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="title">帖子名称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_id">用户ID</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user_id">
                            </div>
                        </div>

                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">用户名</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="user_name">
                        </div>
                    </div>

                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="guba_id">所属股吧ID</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="guba_id">
                        </div>
                    </div>

                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">帖子内容</label>

                        <div class="col-sm-10">
                            <div class="editor">
                                <div class="e_editor">
                                    <textarea name="content"></textarea>
                                </div>
                                <div class="e_toolbar">
                                    <span class="e_face">表情</span>
                                    <span class="e_image">图片</span>
                                </div>
                            </div>
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