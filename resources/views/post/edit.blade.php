@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">编辑股吧</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>股吧管理
                </li>
                <li class="active">
                    <strong>编辑股吧</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/post/update') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="title">帖子名称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="{{ $data->title }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_id">用户ID</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user_id" value="{{ $data->user_id }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">用户名</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user_name" value="{{ $data->user_name }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="guba_id">股吧ID</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="guba_id" value="{{ $data->guba_id }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="tag">标签</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="tag"  value="{{ $data->tag }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">帖子类型</label>

                            <div class="col-sm-10">
                                <select name="type" class="form-control">
                                    <option value="0" @if($data->type == 0) selected="selected" @endif>匿名用户</option>
                                    <option value="1" @if($data->type == 1) selected="selected" @endif>正常用户</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">帖子内容</label>

                            <div class="col-sm-10">
                                <div class="editor">
                                    <div class="e_editor">
                                        <?php $replay = DB::table('replay')->where('post_id', $data->id)->where('storey', 1)->first();?>
                                        <textarea name="content">{!! $replay->content !!}</textarea>
                                    </div>
                                    <div class="e_toolbar">
                                        <span class="e_face">表情</span>
                                        <span class="e_image">图片</span>
                                    </div>
                                </div>
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