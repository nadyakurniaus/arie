<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    public function pembayaran(){
        return $this->belongsTo('App\Pembayaran', 'id');
    }
    public function item(){
        return $this->hasMany('App\ordered_item','id');
    }

    public function scopeBetween($query, $from, $to)
    {
        $query->whereBetween('tanggal_order', [$from, $to]);
    }

}
