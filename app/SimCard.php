<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    // relations to be returned with phone numbers
    protected $with = [
      'network_provider'
    ];

    // Fields that can be filled from the API
    protected $fillable = [
      'sim_number', 'network_provider_id',
    ];

    // Fields not to be returned
    protected $hidden = ['network_provider_id', 'created_at', 'updated_at'];

    /**
     * Devices
     * Function which defines the relationship between a sim card and a device.
     */
    public function devices () {
      return $this->belongsToMany('App\Device')->withPivot('assignment_start', 'assignment_end');
    }
    /**
     * Phone Numbers
     * Function which defines the relationship between a sim card and a phone
     * number.
     */
    public function phone_numbers () {
      return $this->belongsToMany('App\PhoneNumber')->withPivot('assignment_start', 'assignment_end');
    }

    /**
     * Phone Number
     * Function which returns a single related phone number
     */
    public function phone_number ($phone_number_id) {
      return $this->phone_numbers->where('id', $phone_number_id)->first();
    }

    /**
     * Active Phone Numbers
     * Function which returns a collection of phone numbers where the assignment
     * end field is null (i.e. assignment has not ended).
     */
    public function active_phone_numbers () {
      return $this->phone_numbers()->wherePivot('assignment_end', null);
    }

    /**
     * Inactive Phone Numbers
     * Function which returns a collection of phone numbers where the assignment
     * end field is not null (i.e. assignment has ended).
     */
    public function inactive_phone_numbers () {
      return $this->phone_numbers()->wherePivot('assignment_end', '!=', null);
    }

    /**
     * Network Provider
     * Function which defines the relationship between a sim card and a network
     * provider.
     */
    public function network_provider () {
      return $this->belongsTo('App\NetworkProvider');
    }
}
