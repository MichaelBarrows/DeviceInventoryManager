<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatingSystem extends Model
{
    public function device_model () {
      return $this->belongsToMany('App\DeviceModel');
    }
}
