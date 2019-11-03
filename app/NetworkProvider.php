<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetworkProvider extends Model
{
    public function sim_cards () {
      return $this->hasMany('App\SimCard');
    }

    public function phone_numbers () {
      return $this->hasMany('App\PhoneNumber');
    }
}
