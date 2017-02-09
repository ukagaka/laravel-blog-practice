@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">用户列表</h1>
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
                            昵称
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter" >
                            </div>
                        </th>
                        <th>
                            登录邮箱
                            <div class="yadcf-filter-wrapper">
                                <input type="text" class="yadcf-filter" >
                            </div>
                        </th>
                        <th style="width: 225px;">
                            用户组
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
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->email }}</td>
                            <td>{{  \App\User::$group[$v->group_id] }}</td>
                            <td>
                                <a href="{{ url('/user/edit/'.$v->id) }}" class="btn btn-warning btn-sm btn-icon icon-left">
                                    编辑
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