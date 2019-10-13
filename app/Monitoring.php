<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    public function bahan(){
        return $this->belongsTo('App\bahan_baku','id_bahanbaku');
    }
    public function ukuran(){
        return $this->belongsTo('App\UkuranBahan','id_ukuran');
    }
}
