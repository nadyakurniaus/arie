<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordered_item extends Model
{
    public function penjualan()
    {
        return $this->belongsTo('App\Penjualan', 'id_order');
    }
    public function produk()
    {
        return $this->belongsTo('App\Produk','id_produk');
    }
    public function pengambilan(){
        return $this->hasOne('App\pengambilanbarang', 'id');
    }
    public function produksi(){
        return $this->hasOne('App\Produksi', 'id');
    }
}
