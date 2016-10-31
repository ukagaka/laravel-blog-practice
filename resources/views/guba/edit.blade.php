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
                <form action="{{ url('/guba/update') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="alias">股吧名称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="alias" value="{{ $data->alias }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="symbol">股票代码</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="symbol" value="{{ $data->symbol }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">股票名称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="guanzhu">关注数</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="guanzhu" value="{{ $data->guanzhu }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="title">title</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" id="title" value="{{ $data->title }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="description">description</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="description" id="description" value="{{ $data->description }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="keyword">keyword</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="keyword" id="keyword" value="{{ $data->keyword }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">股吧类型</label>

                            <div class="col-sm-10">
                                <select name="type" class="form-control">
                                    <option value="0" @if($data->status == 0) selected="selected" @endif>主题吧</option>
                                    <option value="1" @if($data->status == 1) selected="selected" @endif>股吧</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>

                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="1" @if($data->status == 1) selected="selected" @endif>正常</option>
                                    <option value="0" @if($data->status == 0) selected="selected" @endif>停用</option>
                                </select>
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