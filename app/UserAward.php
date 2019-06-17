<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAward extends GenericModel
{
  public $validationRules = ['date' => 'required|date_format:Y-m-d'];
  public $validationRuleNotRequired = ['user_id'];
  public function systemGenerateValue($entry){
    if(isset($entry['user_id']) && config('payload.roles.100')){

    }else{
      $entry['user_id'] = config('payload.id');
    }
    return $entry;
  }
}
