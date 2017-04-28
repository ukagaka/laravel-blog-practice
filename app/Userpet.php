<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userpet extends Model{

    protected $table = 'user_pet';
    public $timestamps = false;

    public function userinfo()
    {
        return $this->belongsTo('App\User');
    }
}