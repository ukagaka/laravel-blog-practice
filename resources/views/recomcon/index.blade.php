@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">推荐内容列表</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>推荐管理
                </li>
                <li class="active">
                    <strong>推荐内容列表</strong>
                </li>
            </ol>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="btn-toolbar">
                    {{--<div class="btn-group focus-btn-group">--}}
                        {{--<button class="btn btn-default" id="ord-all">--}}
                            {{--重新排序</button>--}}
                    {{--</div>--}}
                    <div class="btn-group dropdown-btn-group pull-right">
                        <a href="{{ url('/recomcon/create?group_id='.$group_id) }}" class="btn btn-default">新建</a>
                    </div>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="replace-inputs">
                        {{--<th style="width: 50px;">--}}
                            {{--排序--}}
                        {{--</th>--}}
                        <th style="width: 109px;">
                            ID
                        </th>
                        <th>
                            帖子内容
                        </th>
                        <th>
                            标题
                        </th>
                        <th>
                            分类
                        </th>
                        <th>
                            时间
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $v)
                        <tr>
                            {{--<td>--}}
                                {{--<div class="yadcf-filter-wrapper-inner">--}}
                                    {{--<input placeholder="输入排序数字" value="{{ $v->orby }}" class="ord-val" data-id="{{ $v->id }}" data-group="{{ $v->group_id }}">--}}
                                {{--</div>--}}
                            {{--</td>--}}
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->title }}</td>
                            <td>{{ $v->ftitle }}</td>
                            <?php $groupData = DB::table('recomgro')->where('id', $v->group_id)->first();?>
                            <td>{{ $groupData->title }}</td>
                            <td>{{ $v->time }}</td>
                            <td>
                                <a href="{{ url('/recomcon/edit/'.$v->id) }}" class="btn btn-warning btn-sm btn-icon icon-left">
                                    编辑
                                </a>
                                <a href="{{ url('/recomcon/delete/'.$v->id) }}" class="btn btn-danger btn-sm btn-icon icon-left" onclick="return confirm('您确定要删除吗？')">
                                    删除
                                </a>
                            </td>
                        </tr>
                    @endforeach
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
        $("#ord-all").click(function(){
            data = new Array();
            ids = '';
            group_id = '';
            $(".ord-val").each(function(){
                ids = $(this).attr("data-id");
                group_id = $(this).attr("data-group");
                data[ids] = $(this).val();
            });
            if(data){
                data = json_encode(data);
                window.location.href = '/recomcon/upord?data=' + data + '&group_id=' + group_id;
            }
        });
    </script>

@endsection