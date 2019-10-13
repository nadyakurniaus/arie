<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    public function ukuran(){
        return $this->belongsTo('App\ukuranbahan','id_ukuran');
    }
    public function bahan(){
        return $this->belongsTo('App\bahan_baku', 'id_bahanbaku');
    }
    public function item(){
        return $this->hasOne('App\OrderTemp','id');
    }
    public function harga(){
        return $this->hasMany('App\Harga','id');
    }
    public function ordered_item(){
        return $this->hasOne('App\ordered_item', 'id');
    }
}
