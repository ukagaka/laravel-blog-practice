<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Support\Facades\Input;

class InterfaceController extends Controller
{
    public function getChuncai()
    {
        $user= Auth::user();
        $code = 100;
        $chuncaiName = 'default';
        $config = [];
        if($user){
            $config = \App\pet::get_wcc_config($user->id);
            unset($config['pet_greeting']);
            unset($config['pet_thinkAloud']);
        }
        if ($user) {
            $userPet = DB::table('user_pet')->where('user_id', $user->id)->where('status', 1)->first();
            if($userPet){
                $pet = DB::table('pet')->where('id', $userPet->pet_id)->first();
                $chuncaiName = $pet->name;
                $code = $userPet->pet_id;
            } else {
                $code = 0;
            }
        }
        $configHtml = '<div id="pet_smchuncai" style="color:#626262;z-index:999;"><div id="pet_chuncaiface"></div><div id="pet_dialog_chat"><div id="pet_chat_top"></div><div id="pet_dialog_chat_contents"><div id="pet_dialog_chat_loading"></div><div id="pet_tempsaying"></div><ul id="pet_showchuncaimenu">';
        foreach ($config as $k => $v) {
            $configHtml .= '<li class="pet_wcc_mlist" id="'.$k.'">'.$v.'</li>';
        }
        $configHtml .= '</ul><div><ul id="pet_chuncaisaying"></ul></div><div id="pet_close">|关闭|</div><div id="pet_getmenu">|菜单|</div></div><div id="pet_chat_bottom"></div></div></div><div id="pet_callchuncai">召唤春菜</div>';
        $msg = '';
        if($code != 0){
            $fpath = 'ukagaka/skin/'.$chuncaiName.'/face1.gif';
            $size = getimagesize($fpath);
            $code = 2;
            $num = count(scandir('ukagaka/skin/'.$chuncaiName))-2;
            $msg = ['chuncaiName'=>$chuncaiName, 'chuncaiUrl'=> url('ukagaka/skin/'),'imagewidth'=>$size['0'],'imageheight'=>$size['1'],'num'=>$num, 'configHtml' => $configHtml];
        }
        $data = ['code'=>$code,'msg'=>$msg];
        return response()->json($data);
    }

    public function getNotice()
    {
        $user= Auth::user();
        if($user){
            return response()->json(['code'=>1,'msg'=>'我是系统公告，我是系统公告，我是系统公告']);
        }else{
            return response()->json(['code'=>0,'msg'=>"伪春菜：前方高能，请出示您的通行证~<div class='pet_login'><a href='/login'>出示通行证</a></div>"]);
        }
    }

    public function measurements()
    {
        $user = Auth::user();
        if($user){
            $userPet = DB::table('user_pet')->where('user_id', $user->id)->where('status', 1)->first();
        } else {
            return [];
        }
        $pet = DB::table('pet_info')->where('id', $userPet->id)->first();
        $petInfo = array('uid'=>$user->id,'grade'=>$pet->level,'exp'=>10,'eat'=>10,'hungry'=>10,'charm'=>10,'static'=>10,'name'=>$userPet->nick,'type'=>1,'time'=>$userPet->created_at);
        if($userPet->uname){
            $uname = $userPet->uname;
        } else {
            $uname = $user->name;
        }
        $expSum = floor((pow(1.8,$petInfo['grade'])*100+20)/100)*100;
        $hungry = \App\Pet::get_wcc_hungry($user->id);
        $lifetime = \App\Pet::get_wcc_lifetime(strtotime($petInfo['time']));
        $measurements = '等级：'.$petInfo['grade'].'<br/>经验：'.$petInfo['exp'].'/'.$expSum.'<br/>饥饿：'.$hungry.'/100<br/>活力：100/100<br/>魅力：0<br/>';
        return response()->json(['code'=>0,'msg'=>$measurements]);
    }

    public function package()
    {
        $user = Auth::user();
        if($user){
            $package = array(array('id'=>1,'name'=>'勺子','intro'=>'我是勺子的介绍','cont'=>3),array('id'=>2,'name'=>'锤子','intro'=>'我是锤子的介绍','cont'=>1));
        }
        return response()->json(['code'=>1,'msg'=>array('item'=>$package,'total'=>count($package))]);
    }

    public function talkcon()
    {
        //图灵机器人API，POST请求，用来做聊天使用
        $url = 'http://www.tuling123.com/openapi/api';
        $key = '41027ee4b024a89d55c0f425b591dced';
        $problem = Input::get('talkcon');
        $data = 'key='.$key.'&info='.$problem.'&userid=12';
        $answer = $this->request($url, $data);
        return $answer;
    }

    public function eat()
    {
        $type = Input::get('type');
        $eatFoods = array(
            1=>'爱心早餐',
            2=>'幸福便当',
            3=>'烛光晚宴',
            10001=>'士力架（消耗钻石15）',
            10002=>'薯片（消耗钻石10）',
            10003=>'可乐（消耗钻石12）',
        );
        $eatSay = array(
            1=>'这是主人给我的爱心便当吗，kiss~',
            2=>'看到主人，我的心里就满满的',
            3=>'两，两，两个人的烛光晚宴',
            10001=>'横扫饥饿，做回自己',
            10002=>'我最爱吃薯片了',
            10003=>'可乐陪薯片才是最棒的',
        );
        $uid = 1;
        $dataTime = date("Y-m-d");
        if($type < 10000 && $type > 0){
            if(\App\Pet::threeMeals($type)){
                return response()->json(['code'=>0,'msg'=>$eatSay[$type]]);
            }else{
                return response()->json(['code'=>1,'msg'=>'主人，你有零食么？']);
            }
        }elseif($type <= 10003 && $type > 10000){
            $eatTime = \App\Pet::eatEgg($type);
            $eatTime>4?4:$eatTime;
            if($eatTime){
                return response()->json(['code'=>0,'msg'=>$eatSay[$type]]);
            }else{
                return response()->json(['code'=>3,'msg'=>"嗝~，好饱，好饱，让我休息".(4-$eatTime)."个小时在吃"]);
            }
        }else{
            return response()->json(['code'=>1,'msg'=>$eatFoods]);
        }

    }

    public function carrying()
    {
        /**
         * 运送物资返回的数据
         * 1。运送物资如果押金不够返回数据
         * 2.运送物资已经有5个小时的时候，返回运送物资所得的钻石
         * 3.运送物资不够5个小时的时候，返回的参数
         *
         */
        $consumeEgg = 10;
        $risk = 4;
        $uid = 1;
        $dataTime = '2016-01-02 13:20:20';
        $userEgg = 30;
        if($userEgg < $consumeEgg){
            return response()->json(['code'=>3,'msg'=>"报告舰长，我军钻石不足，请补充后再运送"]);
        }
        $hTime = date("G");
        $materialTime = time() - strtotime($dataTime);
        $materialTime = floor($materialTime/3600);
        if($materialTime >= 5){
            $odds = rand(5,20);
            return response()->json(['code'=>1,'msg'=>"经过千山万水，我军终于返回港口，带回钻石{$odds}个"]);
        }
        return response()->json(['code'=>3,'msg'=>"舰长SAMA，物资正在运送当中,预计".(5-$materialTime)."小时后抵达"]);
    }

    public function constellation()
    {
        $url = 'http://web.juhe.cn:8080/constellation/getAll';
        $key = '64fb8d8cff679d07c5cfc004d13c0026';
        $consName = Input::get('type');
        $data = 'key='.$key.'&consName='.$consName.'&type=today';
        $answer = $this->request($url,$data);
        return $answer;
    }

    public function calendar()
    {
        $url = 'http://v.juhe.cn/laohuangli/d';
        $key = 'c4d61632cd9feadb1033ba8e6d458580';
        $consName = date("Y-m-d");
        $data = 'key='.$key.'&date='.$consName;
        $answer = $this->request($url,$data);
        return $answer;
    }

    public function oneiromancy()
    {
        $url = 'http://v.juhe.cn/dream/query';
        $key = 'fb14a14ffc9510609e43ddd061dc4cca';

        $consName = $_GET['keyword'];
        $data = 'key='.$key.'&q='.$consName;
        $answer = $this->request($url, $data);
        return $answer;
    }

    public function mission()
    {
        /**
         * 剧情任务返回的一些对话
         *
         */
        $task = array(
            'message'=>array(
                array(
                    'key'=>'sys1',
                    'talk'=>'远处飘来一阵香味~',
                    'expression'=>1,
                    'answer'=>array(
                        array(
                            'key'=>'cai1',
                            'name'=>'春菜',
                            'content'=>'咦，前面有什么香味~',
                        )
                    )
                ),
                array(
                    'key'=>'cai1',
                    'talk'=>'说着，春菜，又用鼻子嗅了嗅',
                    'expression'=>1,
                    'answer'=>array(
                        array(
                            'key'=>'cai2',
                            'name'=>'你',
                            'content'=>'哦，前面好像是新开了一个餐厅',
                        ),
                        array(
                            'key'=>'cai4',
                            'name'=>'你',
                            'content'=>'哪有什么味啊，我怎么没看闻到啊',
                        ),
                    )
                ),
                array(
                    'key'=>'cai2',
                    'talk'=>'主人~，人家肚肚饿了~ ＞﹏＜',
                    'expression'=>3,
                    'answer'=>array(
                        array(
                            'key'=>'cai3',
                            'name'=>'你',
                            'content'=>'好吧，好吧，真拿你没办法，那我们一起去吃吧',
                        ),
                    )
                ),
                array(
                    'key'=>'cai3',
                    'talk'=>'偶也，主人最好了',
                    'expression'=>2,
                    'answer'=>array(
                        array(
                            'key'=>'sys2',
                            'name'=>'旁白君',
                            'content'=>'你们一起走进餐厅',
                        ),
                    )
                ),
                array(
                    'key'=>'cai4',
                    'talk'=>'真的，真的有啊，主人陪我一起去看看去吗！',
                    'expression'=>3,
                    'answer'=>array(
                        array(
                            'key'=>'sys2',
                            'name'=>'你',
                            'content'=>'好吧，好吧，我们一起去看看吧',
                        ),
                        array(
                            'key'=>'cai5',
                            'name'=>'你',
                            'content'=>'我现在很忙，那有时间，下次吧',
                        ),
                    )
                ),
                array(
                    'key'=>'cai5',
                    'talk'=>'“主人~”，春菜露出可怜兮兮的表情',
                    'expression'=>3,
                    'answer'=>array(
                        array(
                            'key'=>'end',
                            'name'=>'旁白君',
                            'content'=>'结束',
                        ),
                    )
                ),
                array(
                    'key'=>'sys2',
                    'talk'=>'欢迎光临，这里是“团子工坊”，现在光临本店，只要对本店做出评价，说出吐槽，会有小礼品相送哦~',
                    'expression'=>0,
                    'answer'=>array(
                        array(
                            'key'=>'you1',
                            'name'=>'春菜',
                            'content'=>'唉啊，还有礼品相送，太好了',
                        ),
                    )
                ),
                array(
                    'key'=>'you1',
                    'talk'=>'可是具体要怎么操作呢？',
                    'expression'=>0,
                    'answer'=>array(
                        array(
                            'key'=>'sys3',
                            'name'=>'旁白君',
                            'content'=>'继续',
                        ),
                    )
                ),
                array(
                    'key'=>'sys3',
                    'talk'=>'只需要在评论区发表2条评论，再次打开本页面，便会有小礼品相送了',
                    'expression'=>0,
                    'answer'=>array(
                        array(
                            'key'=>'end',
                            'name'=>'旁白君',
                            'content'=>'结束',
                        ),
                    )
                ),
            )
        );
        $name = '剧情名称';
        return \App\Pet::isComplete($name,$task);
    }

    private function request($url,$data)
    {
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch,CURLOPT_TIMEOUT,5);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        $respones=curl_exec($ch);
        curl_close($ch);
        return $respones;
    }
}
