<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestDetail extends Model
{
    protected $guarded = [];

    public function barang()
    {
        return $this->hasOne('App\Models\Barang', 'id', 'barang_id');
    }
}
