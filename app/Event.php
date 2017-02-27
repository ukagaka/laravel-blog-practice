<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model{

    protected $table = 'event';
    public $timestamps = false;

    public static $type = [
        'announce' => '公告',
        'remind' => '通知',
        'dynamic' => '动态',
        'message' => '信息',
    ];

    public static $action = [
        '1' => '评论',
        '2' => '收藏',
        '3' => '关注',
        '4' => '回复',
        '5' => '新帖',
        '6' => '标签'
    ];

    public static $targetType = [
        'post' => '帖子',
        'replay' => '评论',
        'guba' => '股吧',
        'tag' => '标签'
    ];

}