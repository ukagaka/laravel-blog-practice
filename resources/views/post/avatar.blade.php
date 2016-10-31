@extends('layouts.main')

@section('content')

    <div class="page-title">

        <div class="title-env">
            <h1 class="title">新建帖子</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <i class="fa-home"></i>帖子管理
                </li>
                <li class="active">
                    <strong>新建帖子</strong>
                </li>
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <form action="{{ url('/post/updateAvatar') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-4">File Field</label>

                        <div class="col-sm-10">
                            <input type="file" name="photo" class="form-control" id="field-4">
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