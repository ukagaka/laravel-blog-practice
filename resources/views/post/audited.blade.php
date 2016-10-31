@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">帖子列表</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>帖子管理
                </li>
                <li class="active">
                    <strong>帖子列表</strong>
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
                                    <option value="guba_id">股吧ID</option>
                                </select>
                            </label>
                            <label><input type="search" class="form-control input-sm" id="search-input" data-searurl="post"></label>
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
                            标题
                        </th>
                        <th>
                            创建者
                        </th>
                        <th style="width: 109px;">
                            股吧ID
                        </th>
                        <th>
                            股吧名
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $v)
                        <?php $gubaData = DB::table('guba')->where('id', $v->guba_id)->first();?>
                        <tr>
                            <td>
                                <div class="cbr-replaced checked-val" data-id="{{ $v->id }}">
                                    <div class="cbr-state">
                                        <span></span>
                                    </div>
                                </div>
                            </td>
                            <td><a href="http://guba.2258.com/{{ $gubaData->name }}/{{ $v->id }}" target="_blank">{{ $v->id }}</a></td>
                            <td class="repimg"><a href="http://guba.2258.com/{{ $gubaData->name }}/{{ $v->id }}" target="_blank">{{ $v->title }}</a>
                                <div class="bootstrap-tagsinput" style="background:transparent;border:0;" >
                                    <?php $reconData = DB::table('recomcon')->where('title', $v->id)->get();?>
                                    @if($v->jingpin != 0)
                                        <span class="tag label label-red">精品<span data-id="{{ $v->id }}" data-type="jingpin" data-role="remove" class="remove" onclick="return confirm('您确定要删除精品吗？')"></span></span>
                                    @endif
                                    @if($reconData)
                                        @foreach($reconData as $value)
                                            <span class="tag label label-info">{{ $reconmGro[$value->group_id] }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="rev-tab-td">
                                <div class="rev-tab-div">{{ $v->user_name }} </div>
                                <input class="knob rev-tab-input" value="{{ $v->user_name }}" data-id="{{ $v->id }}" data-operation="user_name" data-opeurl="post">
                            </td>
                            <td><a href="http://guba.2258.com/{{ $gubaData->name }}" target="_blank">{{  $v->guba_id }}</a></td>
                            <td><a href="http://guba.2258.com/{{ $gubaData->name }}" target="_blank">{{  $gubaData->name }}</a></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">
                            <span class="btn btn-secondary btn-single" id="ok-all">通过</span>
                            <span class="btn btn-danger btn-single" id="del-all">删除</span>
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

    <script>
        $("#del-all").click(function(){
            ids = '';
            $(".cbr-checked").each(function(){
                if ($(this).attr("data-id")) {
                    ids += $(this).attr("data-id")+'|';
                }
            });
            if(ids){
                ids = ids.substring(0, ids.length - 1);
                window.location.href = '/post/cancel/'+ ids+'?status=0';
            }
        });
        $("#ok-all").click(function(){
            ids = '';
            $(".cbr-checked").each(function(){
                if ($(this).attr("data-id")) {
                    ids += $(this).attr("data-id")+'|';
                }
            });
            if(ids){
                ids = ids.substring(0, ids.length - 1);
                window.location.href = '/post/cancel/'+ ids+'?status=1';
            }
        });
    </script>
@endsection