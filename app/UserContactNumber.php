<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContactNumber extends GenericModel
{
  public $validationRuleNotRequired = ['office', 'direct', 'cell', 'fax', 'user_id'];
  public function systemGenerateValue($entry){
    if(isset($entry['user_id']) && config('payload.roles.100')){

    }else{
      $entry['user_id'] = config('payload.id');
    }
    return $entry;
  }
}
