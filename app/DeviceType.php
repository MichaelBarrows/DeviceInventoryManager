<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    // Fields not to be returned
    protected $hidden = ['id', 'created_at', 'updated_at'];

    /**
     * Device Model
     * Function which defines the relationship between a device type and a
     * device model.
     */
    public function device_model () {
      return $this->belongsToMany('App\DeviceModel');
    }
}
