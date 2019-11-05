<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Fields that can be filled from the API
    protected $fillable = [
        'name', 'email',
    ];

    // Fields not to be returned
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Devices
     * Function which defines the relationship between a user and a device.
     */
    public function devices () {
      return $this->belongsToMany('App\Device')->withPivot('assignment_start', 'assignment_end')->withTimestamps();
    }

    /**
     * Device
     * Function which returns a single related device
     */
    public function device ($device_id) {
      return $this->devices->where('id', $device_id)->first();
    }

    /**
     * Active Devices
     * Function which returns a collection of devices where the assignment
     * end field is null (i.e. assignment has not ended).
     */
    public function active_devices () {
      return $this->devices()->wherePivot('assignment_end', null);
    }

    /**
     * Inactive Devices
     * Function which returns a collection of devices where the assignment
     * end field is not null (i.e. assignment has ended).
     */
    public function inactive_devices () {
      return $this->devices()->wherePivot('assignment_end', '!=', null);
    }
}
