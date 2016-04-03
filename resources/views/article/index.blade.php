@extends('public.basic')
@section('menu')
    <ul class="nav nav-sidebar">
        <li class="active"><a href="#">文章管理 <span class="sr-only">(current)</span></a></li>
        <li><a href="#">发表文章</a></li>
        <li><a href="#">Analytics</a></li>
        <li><a href="#">Export</a></li>
    </ul>
@stop
@section('content')
    <table class="table">
        <tr>
            <td><input type="checkbox"></td>
            <td>id</td>
            <td>标题</td>
            <td>操作</td>
        </tr>
        @forelse($articles as $article)
            <tr>
                <td><input type="checkbox"></td>
                <td>{{$article->id}}</td>
                <td>{{$article->title}}</td>
                <td><a href="#">编辑</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="4"></td>
            </tr>
        @endforelse
    </table>
@endsection