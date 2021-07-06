<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POrder extends Model
{
    protected $table = 'orders';
    protected $guarded = [];

    public function approve()
    {
        return $this->hasOne('App\User', 'id','approve_id');
    }

    public function request()
    {
        return $this->hasOne('App\Models\PRequest', 'id','request_id');
    }

    public function supplier()
    {
        return $this->hasOne('App\Models\Supplier', 'id','suplier_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }
}
