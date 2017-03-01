<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'luoyinghao',
            'email' => 'luoyinghao@gmail.com',
            'group_id' => 1,
            'status' => 1,
            'password' => bcrypt('123456'),
        ]);

        DB::table('pet')->insert([
            'name' => 'default',
            'user_id' => 1,
        ]);

        DB::table('user_pet')->insert([
            'user_id' => 1,
            'pet_id' => 1,
            'exp' => 1,
        ]);

        DB::table('event')->insert([
            'sender' => '系统',
            'sener_id' => 0,
            'action' => 7,
            'target' => 0,
            'target_type' => 'announce',
            'content' => '这是通告，通告听到了吗？听到了请回答，听到了请回答',
            'type' => 'remind',
            'receiver' => 0,
            'is_read' => 1,
            'time' => date('Y-m-d H:i:s')
        ]);

    }
}
