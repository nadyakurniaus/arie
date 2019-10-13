<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pengambilanbarang extends Model
{
    public function order(){

        return $this->belongsTo('App\ordered_item','id_order');
        
    }
}
