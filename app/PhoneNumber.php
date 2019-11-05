<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    // relations to be returned with phone numbers
    protected $with = [
      'network_provider'
    ];

    // Fields that can be filled from the API
    protected $fillable = [
      'phone_number', 'network_provider_id',
    ];

    /**
     * Network Provider
     * Function which defines the relationship between a phone number and a
     * network provider
     */
    public function network_provider () {
      return $this->belongsTo('App\NetworkProvider');
    }

    /**
     * Sim Cards
     * Function which defines the relationship between a phone number and a
     * sim card
     */
    public function sim_cards () {
      return $this->belongsToMany('App\SimCard')->withPivot('assignment_start', 'assignment_end');
    }
}
