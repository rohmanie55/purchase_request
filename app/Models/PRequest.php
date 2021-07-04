<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PRequest extends Model
{
    protected $table = 'requests';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\RequestDetail', 'request_id');
    }
}
