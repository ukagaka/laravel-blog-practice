@extends('public.basic')
@section('menu')
    <ul class="nav nav-sidebar">
        <li class="active"><a href="/article">文章管理 <span class="sr-only">(current)</span></a></li>
        @parent
    </ul>
@stop
@section('content')
    <h2>{{$article->title}}</h2>
    <hr>
    {!! $article->content !!}

@endsection
