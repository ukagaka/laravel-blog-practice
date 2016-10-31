@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">标签列表</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>标签管理
                </li>
                <li class="active">
                    <strong>标签列表</strong>
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
                                    <option value="tag">标签名称</option>
                                    <option value="user_id">用户ID</option>
                                </select>
                            </label>
                            <label><input type="search" class="form-control input-sm" id="search-input" data-searurl="tagno"></label>
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
                            标签名称
                        </th>
                        <th>
                            帖子
                        </th>
                        <th>
                            用户ID
                        </th>
                        <th>
                            状态
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
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->tag }}</td>
                            <?php $postData = DB::table('post')->where('id', $v->post_id)->first();?>
                            <td>{{ $postData->title }}</td>
                            <td>{{ $v->user_id }}</td>
                            <td>@if($v->status == 0) 未通过 @else  通过  @endif</td>
                            <td>
                                <a href="{{ url('/tag/cancel/'.$v->id.'?status=1') }}" class="btn btn-secondary btn-sm btn-icon icon-left" onclick="return confirm('您确定要通过审核吗？')">
                                    通过
                                </a>
                                <a href="{{ url('/tag/delete/'.$v->id) }}" class="btn btn-danger btn-sm btn-icon icon-left" onclick="return confirm('您确定要删除吗？')">
                                    删除
                                </a>
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="7">
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
                window.location.href = '/tag/delete/'+ ids;
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
                window.location.href = '/tag/cancel/'+ ids+'?status=1';
            }
        });
    </script>

@endsection