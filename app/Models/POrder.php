<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POrder extends Model
{
    protected $table = 'orders';
    protected $guarded = [];

    public function supplier()
    {
        return $this->hasOne('App\Models\Supplier', 'id','suplier_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }
}
