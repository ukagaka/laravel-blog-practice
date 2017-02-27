@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">编辑公告</h1>
        </div>
    </div>
<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-default">
            <form action="{{ url('/event/update') }}" class="form-horizontal" method="post">
                {!! csrf_field() !!}
                <div class="panel-body">


                    <div class="form-group">
                        <label class="col-sm-2 control-label">通知内容</label>

                        <div class="col-sm-10">
                            <div class="editor">
                                <div class="e_editor">
                                    <textarea id="editor" name="content">{!! $data->content !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="receiver">接收人ID</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="receiver" id="receiver" value="{{ $data->receiver }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">接收人</label>

                        <div class="col-sm-10">
                            <?php $user = \App\User::where('id', $data->receiver)->first();?>
                            <input type="text" class="form-control" id="userNick" value="{{ $user?$user->name:'所有人' }}" disabled="">
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

<script>
    $("#receiver").blur(function(){
        userId = $(this).val();
        $.getJSON('/user/getUser/'+userId, function(data){
            if(data.code == 'success'){
                $("#userNick").val(data.data['nick']);
                return true;
            }
            return false;
        });
    });
</script>
@endsection

@section('js')
    <script src="/assets/dist/js/apiEditor.js"></script>
@endsection