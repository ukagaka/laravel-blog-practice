<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model{

    protected $table = 'user_info';
    public $timestamps = false;

    public function userinfo()
    {
        return $this->belongsTo('App\User');
    }
}