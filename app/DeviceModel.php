<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    // Fields not to be returned
    protected $hidden = ['id', 'manufacturer_id', 'operating_system_id', 'device_type_id', 'created_at', 'updated_at'];

    /**
     * Device Type
     * Function which defines the relationship between a device model and a
     * device type.
     */
    public function device_type () {
      return $this->belongsTo('App\DeviceType');
    }

    /**
     * Manufacturer
     * Function which defines the relationship between a device model and a
     * manufacturer.
     */
    public function manufacturer () {
      return $this->belongsTo('App\Manufacturer');
    }

    /**
     * Operating System
     * Function which defines the relationship between a device model and an
     * operating system.
     */
    public function operating_system () {
      return $this->belongsTo('App\OperatingSystem');
    }

    /**
     * Devices
     * Function which defines the relationship between a device model and a
     * device.
     */
    public function devices () {
      return $this->hasMany('App\Device');
    }
}
