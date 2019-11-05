<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetworkProvider extends Model
{
    // Fields not to be returned
    protected $hidden = ['id', 'created_at', 'updated_at'];

    /**
     * Sim Cards
     * Function which defines the relationship between a network provider and a
     * sim card.
     */
    public function sim_cards () {
      return $this->hasMany('App\SimCard');
    }

    /**
     * Device Model
     * Function which defines the relationship between a network provider and a
     * phone number.
     */
    public function phone_numbers () {
      return $this->hasMany('App\PhoneNumber');
    }
}
