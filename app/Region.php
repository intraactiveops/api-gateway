<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends GenericModel
{
  public function country()
  {
      return $this->belongsTo('App\Country');
  }
}
