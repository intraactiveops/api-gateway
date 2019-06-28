<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEducationalBackground extends GenericModel
{
  public $validationRules = [
    "year_started" => 'numeric|min:1521|required|max:3000'
  ];
  public $validationRuleNotRequired = ['user_id', 'year_ended'];
  public function systemGenerateValue($entry){
    if(isset($entry['user_id']) && config('payload.roles.100')){

    }else{
      $entry['user_id'] = config('payload.id');
    }
    return $entry;
  }
}
