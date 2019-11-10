<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    // relations to be returned with devices
    protected $with = [
      'device_model.manufacturer', 'device_model', 'device_model.device_type', 'device_model.operating_system'
    ];

    // Fields that can be filled from the API
    protected $fillable = [
      'serial_number', 'imei', 'device_model_id',
    ];

    // Fields not to be returned
    protected $hidden = ['device_model_id', 'created_at', 'updated_at'];

    /**
     * Users
     * Function which defines the relationship between a device and a user.
     */
    public function users () {
      return $this->belongsToMany('App\User')->withPivot('assignment_start', 'assignment_end');
    }

    /**
     * User
     * Function which returns a single related user
     */
    public function user ($user_id) {
      return $this->users->where('id', $user_id)->first();
    }

    /**
     * Active Users
     * Function which returns a collection of users where the assignment
     * end field is null (i.e. assignment has not ended).
     */
    public function active_users () {
      return $this->users()->wherePivot('assignment_end', null);
    }

    /**
     * Inactive Users
     * Function which returns a collection of users where the assignment
     * end field is not null (i.e. assignment has ended).
     */
    public function inactive_users () {
      return $this->users()->wherePivot('assignment_end', '!=', null);
    }

    /**
     * Device Model
     * Function which defines the relationship between a device and a device
     * model.
     */
    public function device_model () {
      return $this->belongsTo('App\DeviceModel');
    }

    /**
     * Sim Cards
     * Function which defines the relationship between a device and a sim card.
     */
    public function sim_cards () {
      return $this->belongsToMany('App\SimCard', 'device_sim_card')->withPivot('assignment_start', 'assignment_end')->withTimestamps();
    }

    /**
     * Sim Card
     * Function which returns a single related sim card
     */
    public function sim_card ($sim_card_id) {
      return $this->sim_cards->where('id', $sim_card_id)->first();
    }

    /**
     * Active Sim Cards
     * Function which returns a collection of sim cards where the assignment
     * end field is null (i.e. assignment has not ended).
     */
    public function active_sim_cards () {
      return $this->sim_cards()->wherePivot('assignment_end', null);
    }

    /**
     * Inactive Sim Cards
     * Function which returns a collection of sim cards where the assignment
     * end field is not null (i.e. assignment has ended).
     */
    public function inactive_sim_cards () {
      return $this->sim_cards()->wherePivot('assignment_end', '!=', null);
    }
}
