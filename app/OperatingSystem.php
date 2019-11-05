<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatingSystem extends Model
{
    // Fields not to be returned
    protected $hidden = ['id', 'created_at', 'updated_at'];

    /**
     * Device Model
     * Function which defines the relationship between an operating system and a
     * device model.
     */
    public function device_model () {
      return $this->belongsToMany('App\DeviceModel');
    }
}
