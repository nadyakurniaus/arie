<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    public function produk(){
        return $this->belongsTo('App\Produk','id_produk');
    }
}
