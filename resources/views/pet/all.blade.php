@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">伪春菜管理</h1>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-xs-5">
                    </div>
                    <div class="col-xs-7">
                        <div class="DTTT_container">
                            <a class="DTTT_button" id="search">搜 索</a>
                        </div>
                        <div id="example-3_filter" class="dataTables_filter">
                            <label>搜索
                                <select id="search-type" name="data-type" aria-controls="example-3" class="form-control input-sm">
                                    <option value="id">ID</option>
                                    <option value="nick">昵称</option>
                                    <option value="user_id">创建人</option>
                                </select>
                            </label>
                            <label><input type="search" class="form-control input-sm" id="search-input" data-searurl="guba"></label>
                        </div>
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
                            英文名
                        </th>
                        <th>
                            昵称
                        </th>
                        <th>
                            状态
                        </th>
                        <th>
                            创建人
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
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->nick }}</td>
                            <td>
                                <div class="form-block">
                                    <input type="checkbox" @if($v->status == 1) checked @endif class="iswitch iswitch-secondary" data-action="status" data-id="{{ $v->id }}">
                                </div>
                            <td>{{ $v->user_id }}</td>
                            <td>
                                <a href="{{ url('/pet/edit/'.$v->id) }}" class="btn btn-secondary btn-sm btn-icon icon-left">
                                    查看
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        $(".iswitch").click(function(){
            _this = $(this);
            status = 0;
            gubaid = _this.attr("data-id");
            action = _this.attr("data-action");
            if(_this.is(':checked')){
                status = 1;
            }
            $.getJSON('/pet/modify', {'id':gubaid , 'action':action, 'value':status}, function(data){
                if(data.code == 'success'){
                    return true;
                }
                return false;
            });
        });
    </script>

@endsection