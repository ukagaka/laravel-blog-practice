@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">公告列表</h1>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-xs-5">
                    </div>
                    <div class="col-xs-7">

                    </div>
                </div>

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="replace-inputs">
                        <th class="no-sorting" style="width: 109px;">
                            <div class="cbr-replaced">
                                <div class="cbr-state">
                                    <span id="checked-all"></span>
                                </div>
                            </div>
                            全选
                        </th>
                        <th style="width: 109px;">
                            ID
                        </th>
                        <th>
                            公告内容
                        </th>
                        <th>
                            公告时间
                        </th>
                        <th>
                            接收人ID
                        </th>
                        <th>
                            接收人姓名
                        </th>
                        <th>
                            状态
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $v)
                        <tr>
                            <td>
                                <div class="cbr-replaced checked-val" data-id="{{ $v->id }}">
                                    <div class="cbr-state">
                                        <span></span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $v->id }}</td>
                            <td class="repimg"><div class="repcon">{!!  $v->content !!}</div> </td>
                            <td>{{  $v->time }}</td>
                            <td>{{  $v->receiver }}</td>
                            <td>
                                <?php $user = \App\User::where('id', $v->receiver)->first();?>
                                {{ $user?$user->name:'所有人' }}
                            </td>
                            <td>
                                <div class="form-block">
                                    <input type="checkbox" @if($v->is_read == 0) checked @endif class="iswitch iswitch-secondary" data-action="is_read" data-id="{{ $v->id }}" data-value="{{ $v->is_read }}">
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('/event/edit/'.$v->id) }}" class="btn btn-warning btn-sm btn-icon icon-left">
                                    编辑
                                </a>
                                <a href="{{ url('/event/delete/'.$v->id) }}" class="btn btn-danger btn-sm btn-icon icon-left" onclick="return confirm('您确定要删除吗？')">
                                    删除
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

    <script>
        $(".iswitch").click(function(){
            _this = $(this);
            status = 1;
            gubaid = _this.attr("data-id");
            action = _this.attr("data-action");
            varlue =  _this.attr("data-varlue");
            if(_this.is(':checked')){
                status = 0;
            }
            $.getJSON('/event/modify', {'id':gubaid , 'action':action, 'value':status}, function(data){
                if(data.code == 'success'){
                    return true;
                }
                return false;
            });
        });
    </script>

@endsection