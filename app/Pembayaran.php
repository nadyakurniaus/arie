<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['tipe_pembayaran'];
    public function penjualan()
    {
        return $this->hasOne('App\Penjualan','id');
    }
}
