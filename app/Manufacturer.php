<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    // Fields not to be returned
    protected $hidden = ['id', 'created_at', 'updated_at'];

    /**
     * Device Model
     * Function which defines the relationship between a manufacturer and a
     * device model.
     */
    public function device_models () {
      return $this->hasMany('App\DeviceModels');
    }
}
