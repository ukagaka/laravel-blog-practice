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
                            <li>等级：{{ $data->exp }}</li>
                            <li>简介： 还没有介绍呢 </li>
                        </ul>
                    </div>

                </div>

                <div class="invoice-details newpeople" >
                    <div class="form-block">
                        问 候：
                        <input type="checkbox" data-type="pet_greeting" @if(array_key_exists('pet_greeting', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        自言自语：
                        <input type="checkbox" data-type="pet_thinkAloud" @if(array_key_exists('pet_thinkAloud', $config)) checked @endif class="iswitch iswitch-secondary" >
                    </div>
                    <div class="form-block">
                        聊天功能：
                        <input type="checkbox" data-type="pet_chatTochuncai" @if(array_key_exists('pet_chatTochuncai', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        喂食功能：
                        <input type="checkbox" data-type="pet_foods" @if(array_key_exists('pet_foods', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        进入后台：
                        <input type="checkbox" data-type="pet_blogmanage" @if(array_key_exists('pet_blogmanage', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        显示三围：
                        <input type="checkbox" data-type="pet_measurements" @if(array_key_exists('pet_measurements', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        查看包裹：
                        <input type="checkbox" data-type="pet_package" @if(array_key_exists('pet_package', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        运送物资：
                        <input type="checkbox" data-type="pet_material" @if(array_key_exists('pet_material', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        星座运势：
                        <input type="checkbox" data-type="pet_constellation" @if(array_key_exists('pet_constellation', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        周公解梦：
                        <input type="checkbox" data-type="pet_oneiromancy" @if(array_key_exists('pet_oneiromancy', $config)) checked @endif class="iswitch iswitch-secondary">
                    </div>
                    <div class="form-block">
                        老黄历：
                        <input type="checkbox" data-type="pet_calendar" @if(array_key_exists('pet_calendar', $config)) checked @endif class="iswitch iswitch-secondary">
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

    <script>
        $(".iswitch").click(function(){
            _this = $(this);
            status = 0;
            petType = _this.attr("data-type");
            action = _this.attr("data-action");
            petId = {{ $data->id }};
            if(_this.is(':checked')){
                status = 1;
            }
            $.getJSON('/pet/updateConfig', {'petId':petId, 'type':petType , 'value':status}, function(data){
                if(data.code == 'success'){
                    return true;
                }
                return false;
            });
        });
    </script>
@endsection
