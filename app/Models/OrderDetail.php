<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];

    public function request()
    {
        return $this->hasOne('App\Models\RequestDetail', 'id','detail_id');
    }

    public function barang()
    {
        return $this->hasOne('App\Models\Barang', 'id','barang_id');
    }
}
