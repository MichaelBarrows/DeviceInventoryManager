<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function users () {
      return $this->belongsToMany('App\User')->withPivot('assignment_start', 'assignment_end');
    }

    public function device_model () {
      return $this->belongsTo('App\DeviceModel');
    }

    public function sim_cards () {
      return $this->belongsToMany('App\SimCard')->withPivot('assignment_start', 'assignment_end');
    }
}
