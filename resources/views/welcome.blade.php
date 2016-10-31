@extends('layouts.main')

@section('content')



    <div class="main-content">
        <div class="col-sm-3">
            <?php $replayCount = DB::table('replay')->where('time', '>', date('Y-m-d 00:00:00'))->where('time', '<', date('Y-m-d 59:59:59'))->count();?>
            <div class="xe-widget xe-counter">
                <div class="xe-icon">
                    <i class="linecons-cloud"></i>
                </div>
                <div class="xe-label">
                    <strong class="num">{{ $replayCount }}</strong>
                    <span>今日评论</span>
                </div>
            </div>

        </div>

        <div class="col-sm-3">
            <?php $postCount = DB::table('post')->where('time', '>', date('Y-m-d 00:00:00'))->where('time', '<', date('Y-m-d 59:59:59'))->count();?>

            <div class="xe-widget xe-counter xe-counter-blue">
                <div class="xe-icon">
                    <i class="linecons-user"></i>
                </div>
                <div class="xe-label">
                    <strong class="num">{{ $postCount }}</strong>
                    <span>今日发帖</span>
                </div>
            </div>

        </div>

        <div class="col-sm-3">
            <?php $gubaCount = DB::table('guba')->count();?>
            <div class="xe-widget xe-counter xe-counter-info" data-count=".num" data-from="0" data-to="{{ $gubaCount }}" data-duration="2" data-easing="true">
                <div class="xe-icon">
                    <i class="linecons-camera"></i>
                </div>
                <div class="xe-label">
                    <strong class="num">0</strong>
                    <span>总股吧数</span>
                </div>
            </div>

        </div>

        <div class="col-sm-3">
            <?php $jubaoCount = DB::table('replay')->where('jubao', '!=' , 0)->where('status', '!=' , 0)->count();?>
            <div class="xe-widget xe-counter xe-counter-red" data-count=".num" data-from="0" data-to="{{ $jubaoCount }}" data-prefix="" data-suffix="" data-duration="2" data-easing="true" data-delay="1">
                <div class="xe-icon">
                    <i class="linecons-lightbulb"></i>
                </div>
                <div class="xe-label">
                    <strong class="num">0</strong>
                    <span>举报评论数</span>
                </div>
            </div>

        </div>

        <div class="col-sm-3">
            <?php $newReplay = DB::table('replay')->where('status', '!=' , 0)->orderBy('time', 'desc')->first();?>
            <div class="xe-widget xe-counter-block">
                <div class="xe-upper">

                    <div class="xe-icon">
                        <i class="linecons-cloud"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">@if($newReplay){{ $newReplay->id }}@endif</strong>
                        <span>最新评论ID</span>
                    </div>

                </div>
                <div class="xe-lower">
                    <div class="border"></div>

                    <span>帖子名称</span>
                    <?php $newPost = DB::table('post')->where('id', $newReplay->post_id)->first();?>
                    <strong>@if($newReplay){{ $newPost->title }}@endif</strong>
                </div>
            </div>

        </div>

        <div class="col-sm-3">
            <?php $newPost = DB::table('post')->where('status', '!=' , 0)->orderBy('time', 'desc')->first();?>
            <div class="xe-widget xe-counter-block xe-counter-block-blue">
                <div class="xe-upper">

                    <div class="xe-icon">
                        <i class="linecons-user"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">@if($newPost){{ $newPost->id }}@else 0 @endif</strong>
                        <span>最新发帖ID</span>
                    </div>

                </div>
                <div class="xe-lower">
                    <div class="border"></div>

                    <span>帖子名称</span>
                    <strong>@if($newPost){{ $newPost->title }}@endif</strong>
                </div>
            </div>

        </div>

        <div class="col-sm-3">
            <?php $newGuba = DB::table('guba')->where('status', '!=' , 0)->orderBy('id', 'desc')->first();?>
            <div class="xe-widget xe-counter-block xe-counter-block-purple">
                <div class="xe-upper">

                    <div class="xe-icon">
                        <i class="linecons-camera"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">@if($newGuba){{ $newGuba->id }}@else 0 @endif</strong>
                        <span>最新股吧ID</span>
                    </div>

                </div>
                <div class="xe-lower">
                    <div class="border"></div>

                    <span>股吧名称</span>
                    <strong>@if($newGuba){{ $newGuba->name }}@endif</strong>
                </div>
            </div>

        </div>

        <div class="col-sm-3">
            <?php $newJubao = DB::table('replay')->where('jubao', '!=' , 0)->where('status', '!=' , 0)->orderBy('time', 'desc')->first();?>
            <div class="xe-widget xe-counter-block xe-counter-block-orange">
                <div class="xe-upper">

                    <div class="xe-icon">
                        <i class="fa-life-ring"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">@if($newJubao){{ $newJubao->id }}@else 0 @endif</strong>
                        <span>最新举报ID</span>
                    </div>

                </div>
                <div class="xe-lower">
                    <div class="border"></div>

                    <span>举报内容</span>
                    <strong>@if($newJubao){{ $newJubao->content }}@else 暂无 @endif</strong>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">每日注册人数</h3>
                    </div>
                    <?php
                    $dataSource = '[';
                        for($i = 6; $i >= 0; $i--){
                            $timeDay = date('Y-m-d', strtotime('-'.$i.' days'));
                            $reUserCount = DB::connection('mysql_auth')->table('user')->where('register_at', '>=', $timeDay)->where('register_at', '<=', $timeDay.' 59:59:59')->count();
                            $timeDay = date('Y年m月d日', strtotime('-'.$i.' days'));
                            $dataSource .= '{day:"'.$timeDay.'", africa:'.$reUserCount.'},';
                        }
                    $dataSource .= ']';
                    ?>
                    <div class="panel-body">

                        <script type="text/javascript">
                            jQuery(document).ready(function($)
                            {
                                var dataSource = {!! $dataSource !!};
                                $("#bar-1").dxChart({
                                    dataSource: dataSource,
                                    commonSeriesSettings: {
                                        argumentField: "day",
                                    },
                                    series: [{
                                        argumentField: "day",
                                        valueField: "africa",
                                        name: "每日注册人数",
                                        color: "#8dc63f",
                                        label: {
                                            visible: true
                                        }
                                    }],
                                    argumentAxis:{
                                        argumentType: 'string',
                                        grid:{
                                            visible: true
                                        }
                                    },
                                    tooltip:{
                                        enabled: true
                                    },
                                    title: "每日注册人数",
                                    legend: {
                                        verticalAlignment: "bottom",
                                        horizontalAlignment: "center"
                                    },
                                    commonPaneSettings: {
                                        border:{
                                            visible: true,
                                            right: false
                                        }
                                    }
                                });
                            });
                        </script>
                        <div id="bar-1" style="height: 400px; width: 100%;"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">每日发帖数统计</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $tongjiInfo = DB::table('tongji')->orderBy('time', 'desc')->take(7)->get()->toArray();
                        asort($tongjiInfo);
                        $dataSource = '[';
                        foreach ($tongjiInfo as $k=>$v) {
                            $timeDay = date('Y-m-d', strtotime($v->time));
                            $zong = $v->am_post_con + $v->user_post_con;
                            $dataSource .= '{day:"'.$timeDay.'", zong:'.$zong.', am:'.$v->am_post_con.', user:'.$v->user_post_con.'},';
                        }
                        $dataSource .= ']';
                        ?>
                        <script type="text/javascript">
                            jQuery(document).ready(function($)
                            {
                                var dataSource = {!! $dataSource !!};

                                $("#bar-2").dxChart({
                                    dataSource: dataSource,
                                    commonSeriesSettings:{
                                        argumentField: "day"
                                    },
                                    panes: [{
                                        name: "topPane"
                                    }, {
                                        name: "bottomPane"
                                    }],
                                    defaultPane: "bottomPane",
                                    series: [ {
                                        pane: "topPane",
                                        valueField: "zong",
                                        name: "每日帖子总数",
                                        label: {
                                            visible: true
                                        },
                                        color: "#00b19d"
                                    }, {
                                        type: "bar",
                                        valueField: "am",
                                        name: "匿名用户",
                                        label: {
                                            visible: true
                                        },
                                        color: "#8dc63f"
                                    },
                                        {
                                            type: "bar",
                                            valueField: "user",
                                            name: "注册用户",
                                            label: {
                                                visible: true
                                            },
                                            color: "#40bbea"
                                        }
                                    ],
                                    legend: {
                                        verticalAlignment: "bottom",
                                        horizontalAlignment: "center"
                                    },
                                    title: {
                                        text: "每日发帖数"
                                    }
                                });
                            });
                        </script>
                        <div id="bar-2" style="height: 450px; width: 100%;"></div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">每日评论数统计</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $dataSource = '[';
                        foreach ($tongjiInfo as $k=>$v) {
                            $timeDay = date('Y-m-d', strtotime($v->time));
                            $zong = $v->am_replay_con + $v->user_replay_con;
                            $dataSource .= '{day:"'.$timeDay.'", zong:'.$zong.', am:'.$v->am_replay_con.', user:'.$v->user_replay_con.'},';
                        }
                        $dataSource .= ']';
                        ?>
                        <script type="text/javascript">
                            jQuery(document).ready(function($)
                            {
                                var dataSource = {!! $dataSource !!};

                                $("#bar-3").dxChart({
                                    dataSource: dataSource,
                                    commonSeriesSettings:{
                                        argumentField: "day"
                                    },
                                    panes: [{
                                        name: "topPane"
                                    }, {
                                        name: "bottomPane"
                                    }],
                                    defaultPane: "bottomPane",
                                    series: [ {
                                        pane: "topPane",
                                        valueField: "zong",
                                        name: "每日评论数统计",
                                        label: {
                                            visible: true
                                        },
                                        color: "#00b19d"
                                    }, {
                                        type: "bar",
                                        valueField: "am",
                                        name: "匿名用户",
                                        label: {
                                            visible: true
                                        },
                                        color: "#8dc63f"
                                    },
                                        {
                                            type: "bar",
                                            valueField: "user",
                                            name: "注册用户",
                                            label: {
                                                visible: true
                                            },
                                            color: "#40bbea"
                                        }
                                    ],
                                    legend: {
                                        verticalAlignment: "bottom",
                                        horizontalAlignment: "center"
                                    },
                                    title: {
                                        text: "每日评论数统计"
                                    }
                                });
                            });
                        </script>
                        <div id="bar-3" style="height: 450px; width: 100%;"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-sm-12">

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
                            精品帖子
                            <small></small>
                        </h3>
                    </div>
                </div>
                <div class="xe-body">

                    <ul class="list-unstyled">
                        <?php $retieList = DB::table('post')->where('jingpin', '!=' , 0)->orderBy('time', 'desc')->take(10)->get();?>
                        @foreach($retieList as $k => $v)
                        <li>
                            <div class="xe-comment-entry">
                                <a class="xe-user-img">
                                    <img src="/assets/images/user-2.png" class="img-circle" width="40">
                                </a>

                                <div class="xe-comment">
                                    <a href="#" class="xe-user-name">
                                        <strong>{{ $v->title }}</strong>
                                        @if($v->zhiding)a
                                            <span class="label label-red">置顶</span>
                                        @endif
                                    </a>

                                    <p>最新楼层数：{{ $v->replay_num }}</p>
                                </div>
                            </div>
                        </li>
                       @endforeach
                    </ul>

                </div>
            </div>

        </div>

    </div>



    <script src="/assets/js/xenon-widgets.js"></script>
    <script src="/assets/js/devexpress-web-14.1/js/globalize.min.js"></script>
    <script src="/assets/js/devexpress-web-14.1/js/dx.chartjs.js"></script>
    <script src="/assets/js/toastr/toastr.min.js"></script>

@endsection