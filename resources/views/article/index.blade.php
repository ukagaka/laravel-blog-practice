@extends('public.basic')
@section('menu')
    <ul class="nav nav-sidebar">
        <li class="active"><a href="/article">文章管理 <span class="sr-only">(current)</span></a></li>
        @parent
    </ul>
@stop
@section('content')
    <table class="table table-bordered">
        <tr>
            <td><input type="checkbox" id="check_article"><button class="btn btn-danger btn-xs delete_article">删除</button></td>
            <td>id</td>
            <td>标题</td>
            <td>操作</td>
        </tr>
        @forelse($articles as $article)
            <tr>
                <td><input type="checkbox" name="check" value="{{$article->id}}"></td>
                <td>{{$article->id}}</td>
                <td>{{$article->title}}</td>
                <td><a href="{{url('article',$article->id.'/edit')}}">编辑</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center">暂时没有记录</td>
            </tr>
        @endforelse
    </table>
@endsection

@section('script')
    <script>
        @if(session()->has('create_success')){
            alert("{{session('create_success')}}");
        }
        @endif
        $("#check_article").click(function(){
            var checkedOfAll = $(this).prop('checked');
            $("input[name=check]").prop('checked',checkedOfAll);
        })
        $(".delete_article").click(function(){
            if(confirm('您确定要删除吗？')){
                var ids = [];
                $("input[name=check]:checked").each(function(){
                    ids.push($(this).val());
                })
                $.post('/article/delete',{ids:ids,_method:"DELETE"},function(data){
                    if(data){
                        $("input[name=check]:checked").parent().parent().remove();
                    }
                })
            }
        });
    </script>
@stop