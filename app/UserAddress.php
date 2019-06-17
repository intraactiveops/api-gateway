<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends GenericModel
{
  public $validationRules = [
    'region_id' => 'required|exists:regions,id',
    'city' => 'required|max:100',
    'zip_code' => 'required|max:10'
  ];
  public function region()
  {
      return $this->belongsTo('App\Region')->with(['country']);
  }
}
