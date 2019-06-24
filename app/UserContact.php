<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContact extends GenericModel
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
  public function contact_user(){
    return $this->belongsTo('App\User', 'contact_user_id', 'id');
  }
  public function user($key = "id"){
    return $this->belongsTo('App\User');
  }
}
