@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">举报列表</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>评论管理
                </li>
                <li class="active">
                    <strong>举报列表</strong>
                </li>
            </ol>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="replace-inputs">
                        <th style="width: 109px;">
                            ID
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter">
                            </div>
                        </th>
                        <th>
                            帖子ID
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter" >
                            </div>
                        </th>
                        <th>
                            评论人
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter" >
                            </div>
                        </th>
                        <th>
                            评论内容
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter" >
                            </div>
                        </th>
                        <th>
                            被赞数
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter" >
                            </div>
                        </th>
                        <th>
                            被举报
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter" >
                            </div>
                        </th>
                        <th>
                            评论时间
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter" >
                            </div>
                        </th>
                        <th>
                            操作
                            <div class="yadcf-filter-wrapper"><input type="text" class="yadcf-filter"></div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $v)
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->post_id }}</td>
                            <td>{{ $v->user_name }}</td>
                            <td>{!!  $v->content !!} </td>
                            <td>{{  $v->zan }}</td>
                            <td>{{  $v->jubao }}</td>
                            <td>{{  $v->time }}</td>
                            <td>
                                <a href="{{ url('/replay/cancel/'.$v->id) }}" class="btn btn-info btn-sm btn-icon icon-left post-add" onclick="return confirm('您确定要忽略吗？')">
                                    忽略这条
                                </a>
                                <a href="{{ url('/replay/delete/'.$v->id) }}" class="btn btn-danger btn-sm btn-icon icon-left" onclick="return confirm('您确定要删除这条评论吗？')">
                                    确认删除
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
@endsection