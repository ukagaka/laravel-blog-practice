@extends('public.basic')
@section('menu')
    <ul class="nav nav-sidebar">
        <li class="active"><a href="/article">文章管理 <span class="sr-only">(current)</span></a></li>
        @parent
    </ul>
@stop
@section('content')
    <h1>编辑文章</h1>
    <form class="form-horizontal" method="post" action="/article/{{$article->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">标题</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="title" placeholder="title" name="title" value="{{$article->title}}">
                @if($errors->has('title'))
                    <span class="help-block">
                        {{$errors->first('title')}}
                    </span>
                @endif
            </div>
        </div>
        {{--<div class="form-group">--}}
        {{--<label for="abstract" class="col-sm-2 control-label">摘要</label>--}}
        {{--<div class="col-sm-8">--}}
        {{--<input type="text" class="form-control" id="abstract" placeholder="abstract" name="abstract">--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="form-group">
            <label for="content" class="col-sm-2 control-label">内容</label>
            <div class="col-sm-8">
                <textarea name="content" id="content" cols="30" rows="10">{{$article->content}}</textarea>
                @if($errors->has('conetnt'))
                    <span class="help-block">
                        {{$errors->first('content')}}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>

@endsection