@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">新建股吧</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>股吧管理
                </li>
                <li class="active">
                    <strong>新建股吧</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/guba') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="alias">股吧名称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="alias">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="symbol">股票代码</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="symbol">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">股票名称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="title">title</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">description</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="description" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="keyword">keyword</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="keyword">
                        </div>
                    </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">股吧类型</label>

                            <div class="col-sm-10">
                                <select name="type" class="form-control">
                                    <option value="0">股吧</option>
                                    <option value="1">主题吧</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>

                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="1">正常</option>
                                    <option value="0">停用</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <button type="submit" class="btn btn-info btn-single pull-right">提交</button>
                </div>

                </form>
            </div>

        </div>
    </div>
@endsection