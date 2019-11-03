<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    public function devices () {
      return $this->belongsToMany('App\Device')->withPivot('assignment_start', 'assignment_end');
    }

    public function phone_numbers () {
      return $this->belongsToMany('App\PhoneNumber')->withPivot('assignment_start', 'assignment_end');
    }

    public function network_provider () {
      return $this->belongsTo('App\NetworkProvider');
    }
}
