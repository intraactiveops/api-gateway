<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContactList extends GenericModel
{
  public $validationRules = ['contact_user_id' => "required|exists:users,id"];
  public $validationRuleNotRequired = ['user_id'];
  public function systemGenerateValue($entry){
    if(isset($entry['user_id']) && config('payload.roles.100')){ 

    }else{
      $entry['user_id'] = config('payload.id');
    }
    return $entry;
  }
  public function contact_user_information(){
    return $this->belongsTo('App\UserBasicInformation', 'contact_user_id', 'user_id');
  }
}
