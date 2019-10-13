<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $dates = ['created_at'];
    public function design(){
        return $this->belongsTo('App\ordered_item','id_ordered');
    }
}
