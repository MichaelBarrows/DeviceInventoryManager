<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    public function network_provider () {
      return $this->belongsTo('App\NetworkProvider');
    }

    public function sim_cards () {
      return $this->belongsToMany('App\SimCard')->withPivot('assignment_start', 'assignment_end');
    }
}
