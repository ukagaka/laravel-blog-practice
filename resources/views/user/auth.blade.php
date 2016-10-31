@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">股吧用户管理</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>用户管理
                </li>
                <li class="active">
                    <strong>股吧用户管理</strong>
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
                                    <option value="nick">昵称</option>
                                    <option value="name">用户名</option>
                                    <option value="register_at">日期</option>
                                </select>
                            </label>
                            <label><input type="search" class="form-control input-sm" id="search-input" data-searurl="user/auth"></label>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="replace-inputs">
                        <th style="width: 109px;">
                            用户ID
                        </th>
                        <th>
                            登录名称
                        </th>
                        <th>
                            昵称
                        </th>
                        <th>
                            邮箱
                        </th>
                        <th>
                            手机号
                        </th>
                        <th>
                            注册日期
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $v)
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td>
                               {{ $v->name }}
                            </td>
                            <td>{{ $v->nick }}</td>
                            <td>{{ $v->email }}</td>
                            <td>{{ $v->mobile }}</td>
                            <td>{{ $v->register_at }}</td>
                            <td>
                                <a href="{{ url('/user/authdel/'.$v->id) }}" class="btn btn-danger btn-sm btn-icon icon-left" onclick="return confirm('您确定要永久封停该用户吗？')">
                                    永久封停用户
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