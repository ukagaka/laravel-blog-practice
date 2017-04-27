<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Pet extends Model{

    protected $table = 'user_pet';
    public $timestamps = false;
    public static $config = [
        'pet_greeting' => '问候',
        'pet_thinkAloud' => '自言自语',
        'pet_shownotice' => '显示公告',
        'pet_chatTochuncai' => '聊天功能',
        'pet_foods' => '喂食功能',
        'pet_blogmanage' => '进入后台',
        'pet_measurements' => '显示三围',
        'pet_package' => '查看包裹',
        'pet_material' => '运送物资',
        'pet_constellation' => '星座运势',
        'pet_oneiromancy' => '周公解梦',
        'pet_calendar' => '老黄历',
        'pet_closechuncai' => '隐藏伪春菜',
    ];

    static function get_wcc_config($uid)
    {
        $pet = self::where('user_id', $uid)->where('status', 1)->first();
        if(!$pet){
            abort('404');
        }
        $config = json_decode($pet->config, true);
        if(!$config){
            foreach (self::$config as $k => $v) {
                if(!array_key_exists($k, $config)){
                    $config[$k] = $v;
                }
            }
        }
        return $config;
    }

    static function update_wcc_config($id, $type, $value)
    {
        $userId = Auth::user()->id;
        $pet = self::where('id', $id)->where('user_id', $userId)->where('status', 1)->first();
        $config = json_decode($pet->config, true);
        if (!$config) {
            foreach (self::$config as $k => $v) {
                $config[$k] = $v;
            }
        }
        if ($value) {
            $config[$type] = self::$config[$type];
        } else {
            unset($config[$type]);
        }
        $pet->config = json_encode($config);
        if ($pet->save()) {
            return true;
        }
        return false;
    }

    static function get_wcc_lifetime($starttime)
    {
        $endtime = time();
        $lifetime = $endtime-$starttime;
        $day = intval($lifetime / 86400);
        $lifetime = $lifetime % 86400;
        $hours = intval($lifetime / 3600);
        $lifetime = $lifetime % 3600;
        $minutes = intval($lifetime / 60);
        $lifetime = $lifetime % 60;
        return array('day'=>$day, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$lifetime);
    }

    static function get_wcc_hungry($uid){
        $userEggTask = array('breakfast'=>1,'lunch'=>1, 'dinner'=>1,'uid'=>$uid);
        $hungry = 0;
        $hTime = date("G");
        if($hTime >= 6 && $hTime <=9 ){
            if($userEggTask['breakfast'] != 0){
                $hungry += 30;
            }
        }else if($hTime <=13){
            if($userEggTask['breakfast'] != 0){
                $hungry += 30;
            }
            if($userEggTask['lunch'] != 0){
                $hungry += 35;
            }
        }else if($hTime <= 23){
            if($userEggTask['breakfast'] != 0){
                $hungry += 30;
            }
            if($userEggTask['lunch'] != 0){
                $hungry += 35;
            }
            if($userEggTask['dinner'] != 0){
                $hungry += 35;
            }
        }
        return $hungry;
    }

     //正常的时候，不消耗任何东西
    static function threeMeals($type){
        $hTime = date("G");
        $uid = 1;
        /** @var TYPE_NAME $dailyTasks   1=已经吃过，0表示未吃 */
        $dailyTasks = array('uid'=>$uid,'pet_breakfast'=>0,'pet_lunch'=>0,'pet_dinner'=>0);
        if($hTime >= 6 && $hTime <=9 && $type == 1){
            if($dailyTasks['pet_breakfast'] == 0){
                return true;
            }
        }
        if($hTime >= 11 && $hTime <=13 && $type == 2){
            if($dailyTasks['pet_lunch'] == 0){
                return true;
            }
        }
        if($hTime >=17 && $hTime <= 20 && $type == 3){
            if($dailyTasks['pet_dinner'] == 0){
                return true;
            }
        }
        return false;
    }

    //吃钻石，此为消耗钻石
    static function eatEgg($type){
        $uid = 1;
        $userEgg = array('egg'=>100,'uid'=>$uid);
        $eggNum = 0;
        switch($type){
            case 10001:
                $eggNum = 15;
                break;
            case 10002:
                $eggNum = 10;
                break;
            case 10003:
                $eggNum = 12;
                break;
        }
        if($userEgg['egg'] < $eggNum){
            return response()->json(['code'=>3,'msg'=>"一定是我吃太多了，主人的兜兜里没钻石了QAQ"]);
        }
        /** @var TYPE_NAME $eatTime  来查询用户上次吃零食是什么时候  */
        $eatDay = array('uid'=>$uid,'time'=>'1451581261');
        $eatTime = time() - $eatDay['time'];
        $eatTime = floor($eatTime/3600);
        return $eatTime;
    }


    static function isComplete($name,$task){
        $uid = 1;
        $mision = false;
        /** @var TYPE_NAME $mision=用来判断用户是否已经触发过这个剧情 */
        //$mision = array('uid'=>1,'type'=>1);
        if($mision){
            $success = '恭喜你，获得了小铜锤!';
            echo json_encode(array('code'=>1,'msg'=>$success));
        }else{
            echo json_encode(array('code'=>0,'msg'=>$task));
        }
    }
}