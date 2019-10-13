<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTemp extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Produk','id_produk');
    }
}
