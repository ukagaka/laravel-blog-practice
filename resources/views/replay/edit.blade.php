@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">编辑评论</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>评论管理
                </li>
                <li class="active">
                    <strong>编辑评论</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/replay/update') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="post_id">帖子ID</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="post_id" value="{{ $data->post_id }}" disabled="">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_id">用户ID</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user_id" value="{{ $data->user_id }}" disabled="">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">用户名称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user_name" value="{{ $data->user_name }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="content">评论内容</label>

                            <div class="col-sm-10">
                                <div class="repcon">
                                    {!! $data->content !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <input type="hidden" value="{{ $data->id }}" name="id">
                        <input type="hidden" name="post_id" value="{{ $data->post_id }}">
                        <button type="submit" class="btn btn-info btn-single pull-right">提交</button>
                        </div>
                    </form>
            </div>

        </div>
    </div>
@endsection