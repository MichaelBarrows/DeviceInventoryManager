<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    public function device_type () {
      return $this->hasOne('App\DeviceType');
    }

    public function manufacturer () {
      return $this->belongsTo('App\Manufacturer');
    }

    public function operating_system () {
      return $this->hasOne('App\OperatingSystem');
    }

    public function devices () {
      return $this->hasMany('App\Device');
    }
}
