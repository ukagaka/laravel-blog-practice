@extends('layouts.main')

@section('content')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">{{ $data->nick }}详情</h1>
        </div>
    </div>

    <div class="row">

        <div class="panel panel-default">

            <div class="invoice-env">
                <div class="invoice-header">
                    <div class="invoice-logo">

                        <ul class="list-unstyled">
                            <li><strong>昵称：{{ $data->nick }}</strong></li>
                            <?php $extra = DB::table('pet_info')->where('pet_id', $data->id)->first();?>
                            <li>等级：{{ $extra->level }}</li>
                            <li>简介：{{ $extra->avatar }}</li>
                        </ul>
                    </div>

                </div>

                <div class="invoice-details newpeople" >
                    <div class="form-block">
                        问 候：
                        <input type="checkbox" @if($data->status == 1) checked @endif class="iswitch iswitch-secondary" data-action="status" data-id="{{ $data->id }}">
                    </div>
                    <div class="form-block">
                        自言自语：
                        <input type="checkbox" @if($data->status == 1) checked @endif class="iswitch iswitch-secondary" data-action="status" data-id="{{ $data->id }}">
                    </div>
                </div>

            </div>



        </div>

        <div class="panel panel-default">

            <div class="xe-widget xe-conversations">
                <div class="xe-bg-icon">
                    <i class="linecons-comment"></i>
                </div>
                <div class="xe-header">
                    <div class="xe-icon">
                        <i class="linecons-comment"></i>
                    </div>
                    <div class="xe-label">
                        <h3>
                            消息
                            <small></small>
                        </h3>
                    </div>
                </div>
                <div class="xe-body">

                    <ul class="list-unstyled">

                    </ul>

                </div>
            </div>

        </div>
    </div>
@endsection