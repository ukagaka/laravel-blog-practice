@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">推荐内容编辑</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>推荐管理
                </li>
                <li class="active">
                    <strong>推荐内容编辑</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/recomcon/update') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="title">分类内容</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="{{ $data->title }}" id="title">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="ftitle">标题</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ftitle" value="{{ $data->ftitle }}" id="ftitle">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="orby">排序</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="orby" value="{{ $data->orby }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类</label>

                            <div class="col-sm-10">
                                <select name="group_id" class="form-control">
                                    <?php $recomgro = DB::table('recomgro')->get();?>
                                    @foreach($recomgro as $k=>$v)
                                        <option value="{{ $v->id }}" @if($data->group_id == $v->id) selected="selected" @endif>{{ $v->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">时间</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control no-right-border form-focus-purple" name="time" id="time" value="{{ $data->time }}">

                                    <span class="input-group-btn">
                                        <button onclick="$(this).parent().prev('#time').val('{{ date('Y-m-d H:i:s') }}');" class="btn btn-purple" type="button">当前时间</button>
                                    </span>
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