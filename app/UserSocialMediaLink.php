<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSocialMediaLink extends GenericModel
{
  public $validationRuleNotRequired = ['user_id'];
  public function systemGenerateValue($entry){
    if(isset($entry['user_id']) && config('payload.roles.100')){

    }else{
      $entry['user_id'] = config('payload.id');
    }
    return $entry;
  }
}
