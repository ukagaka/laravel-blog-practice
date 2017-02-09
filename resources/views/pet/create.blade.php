@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">新建伪春菜</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/pet') }}" class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">名称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="nick">昵称</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nick">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="demand['level']">解锁等级</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="demand['level']">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="demand['gold']">解锁金币</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="demand['gold']">
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