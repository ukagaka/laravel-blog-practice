<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'group_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $group = array(
        '0' => '停用',
        '1' => '超级管理员',
        '2' => '管理员'
    );

    public function userinfo()
    {
        return $this->hasOne('App\Userinfo');
    }

    public function pet()
    {
        return $this->hasMany('App\Userpet');
    }
}
