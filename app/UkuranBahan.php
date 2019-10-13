<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UkuranBahan extends Model
{
    public function bahan(){
        return $this->belongsTo('App\bahan_baku','id_bahanbaku');
    }
    public function monitoring(){
        return $this->hasOne('App\monitoring','id_ukuran');
    }

}
