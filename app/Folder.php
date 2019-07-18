<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //リレーション
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
