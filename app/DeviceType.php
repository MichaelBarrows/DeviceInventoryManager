<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    public function device_model () {
      return $this->belongsToMany('App\DeviceModel');
    }
}
