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
