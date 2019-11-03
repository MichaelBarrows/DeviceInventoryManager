<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    public function device_models () {
      return $this->hasMany('App\DeviceModels');
    }
}
