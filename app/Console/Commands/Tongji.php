<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Tongji extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Tongji {--time=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Tongji';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $starttime = $this->option('time')?$this->option('time'):date("Y-m-d",strtotime("-1 day"));
        $am_post_con = DB::table('post')->where('status', '!=', 0)->where('user_id', 0)->where('time', '>=' , $starttime.' 00:00:00')->where('time', '<=' , $starttime.' 59:59:59')->count();
        $user_post_con = DB::table('post')->where('status', '!=', 0)->where('user_id', '!=', 0)->where('time', '>=' , $starttime.' 00:00:00')->where('time', '<=' , $starttime.' 59:59:59')->count();
        $am_replay_con = DB::table('replay')->where('status', '!=', 0)->where('user_id', 0)->where('time', '>=' , $starttime.' 00:00:00')->where('time', '<=' , $starttime.' 59:59:59')->count();
        $user_replay_con = DB::table('replay')->where('status', '!=', 0)->where('user_id', '!=', 0)->where('time', '>=' , $starttime.' 00:00:00')->where('time', '<=' , $starttime.' 59:59:59')->count();
        $tongji = DB::table('tongji')->where('time', $starttime.' 00:00:00')->first();
        if(!$tongji){
            DB::table('tongji')->insert(
                [
                    'am_post_con' => $am_post_con,
                    'user_post_con' => $user_post_con,
                    'am_replay_con' => $am_replay_con,
                    'user_replay_con' => $user_replay_con,
                    'time' => $starttime.' 00:00:00'
                ]
            );
        } else {
            DB::table('tongji')
                ->where('time', $starttime.' 00:00:00')
                ->update([
                    'am_post_con' => $am_post_con,
                    'user_post_con' => $user_post_con,
                    'am_replay_con' => $am_replay_con,
                    'user_replay_con' => $user_replay_con
                ]);
        }

    }
}
