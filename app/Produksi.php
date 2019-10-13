<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Torzer\Common\Traits\MapDateTimeMutator;

class Produksi extends Model
{
    use MapDateTimeMutator;

    protected $mapDateTimeMutator = [
        'jadwal_produksi' => ['from' => 'Y/m/d', 'to' => 'd-m-Y'],
        'date-only' => true,
    ];
    public function order(){
        return $this->belongsTo('App\order','id_order');
    }
    public function bahan_baku(){
        return $this->belongsTo('App\bahan_baku','id_bahan_baku');
    }
    public function ukuran(){
        return $this->belongsTo('App\ukuranbahan','id_ukuran');
    }
    public function item(){
        return $this->belongsTo('App\Penjualan','id_item');
    }
    public function design(){
        return $this->hasOne('App\Design', 'id');
    }

    // private function getStartDateValue() {
    //     return date('d/m/Y', strtotime($this->attributes['jadwal_produksi']));
    //   }

}
