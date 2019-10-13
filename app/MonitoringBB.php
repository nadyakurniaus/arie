<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonitoringBB extends Model
{
    public $table = 'monitoring_b_bs';
    protected $guarded = ['id','created_at','updated_at'];
}
