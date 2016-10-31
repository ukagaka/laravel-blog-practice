@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">股吧列表</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>股吧管理
                </li>
                <li class="active">
                    <strong>股吧列表</strong>
                </li>
            </ol>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-xs-5">
                    </div>
                    <div class="col-xs-7">
                        <div class="DTTT_container">
                            <a class="DTTT_button" id="search">搜 索</a>
                        </div>
                        <div id="example-3_filter" class="dataTables_filter">
                            <label>搜索
                                <select id="search-type" name="data-type" aria-controls="example-3" class="form-control input-sm">
                                    <option value="id">ID</option>
                                    <option value="symbol">股票ID</option>
                                </select>
                            </label>
                            <label><input type="search" class="form-control input-sm" id="search-input" data-searurl="guba"></label>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="replace-inputs">
                        <th class="no-sorting" style="width: 109px;">
                            <div class="cbr-replaced">
                                <div class="cbr-state">
                                    <span id="checked-all"></span>
                                </div>
                            </div>
                            全选
                        </th>
                        <th style="width: 109px;">
                            ID
                        </th>
                        <th>
                            股吧名称
                        </th>
                        <th>
                            股票ID
                        </th>
                        <th>
                            股票名称
                        </th>
                        <th style="width: 109px;">
                            是否允许匿名
                        </th>
                        <th style="width: 109px;">
                            是否允许链接
                        </th>
                        <th>
                            关注
                        </th>
                        <th style="width: 109px;">
                            title
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $v)
                        <tr>
                            <td>
                                <div class="cbr-replaced checked-val" data-id="{{ $v->id }}">
                                    <div class="cbr-state">
                                        <span></span>
                                    </div>
                                </div>
                            </td>
                            <td><a href="http://guba.2258.com/{{ $v->name }}" target="_blank">{{ $v->id }}</a></td>
                            <td>
                                <a href="http://guba.2258.com/{{ $v->name }}" target="_blank">{{ $v->alias }}</a>
                                <div class="bootstrap-tagsinput" style="background:transparent;border:0;" >
                                    <?php $reconData = DB::table('recomcon')->where('title', $v->name)->get();?>
                                    @if($reconData)
                                        @foreach($reconData as $value)
                                            <span class="tag label label-info">{{ $reconmGro[$value->group_id] }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td><a href="http://guba.2258.com/{{ $v->name }}" target="_blank">{{ $v->symbol }}</a></td>
                            <td><a href="http://guba.2258.com/{{ $v->name }}" target="_blank">{{ $v->name }}</a></td>
                            <td>
                                <div class="form-block">
                                    <input type="checkbox" @if($v->enable_anonymous == 1) checked @endif class="iswitch iswitch-secondary" data-action="enable_anonymous" data-id="{{ $v->id }}">
                                </div>
                            </td>
                            <td><div class="form-block">
                                    <input type="checkbox" @if($v->enable_link == 1) checked @endif class="iswitch iswitch-secondary" data-action="enable_link" data-id="{{ $v->id }}">
                                </div>
                            </td>
                            <td><a href="http://guba.2258.com/{{ $v->name }}" target="_blank">{{ $v->guanzhu }}</a></td>
                            <td><a href="http://guba.2258.com/{{ $v->name }}" target="_blank">{{ $v->title }}</a></td>
                            <td>
                                <a href="{{ url('/post?guba_id='.$v->id) }}" class="btn btn-secondary btn-sm btn-icon icon-left">
                                    查看
                                </a>
                                <a href="{{ url('/guba/edit/'.$v->id) }}" class="btn btn-warning btn-sm btn-icon icon-left">
                                    编辑
                                </a>
                                <a href="{{ url('/guba/delete/'.$v->id) }}" class="btn btn-danger btn-sm btn-icon icon-left" onclick="return confirm('您确定要删除吗？')">
                                    删除
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">
                            <span class="btn btn-secondary btn-single" id="rem-all">推送</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="dataTables_info" id="example-3_info" role="status" aria-live="polite">共{{ $data->total() }}条纪录</div>
                    </div>
                    <div class="col-xs-6">
                        <div class="dataTables_paginate paging_simple_numbers">
                            {!! $data->render() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="dropdown-menu pop-up-window" style="right: auto;">
        <div class="pop-up-border">
            <div class="form-group">
                <label class="control-label">推荐位选择</label>
                <select class="form-control" id="pop-select">
                    @foreach($reconmGro as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="range_inputs">
                <button class="applyBtn btn btn-small btn-sm btn-success" id="pop-submit" data-popurl="guba">提交</button>&nbsp;
                <button class="btn btn-small" id="pop-close">取消</button>
            </div>
        </div>
    </div>
    <script>
        $(".iswitch").click(function(){
            _this = $(this);
            status = 0;
            gubaid = _this.attr("data-id");
            action = _this.attr("data-action");
            if(_this.is(':checked')){
                status = 1;
            }
            $.getJSON('/guba/modify', {'id':gubaid , 'action':action, 'value':status}, function(data){
                if(data.code == 'success'){
                    return true;
                }
                return false;
            });
        });
    </script>
@endsection