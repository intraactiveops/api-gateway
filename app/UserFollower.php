<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollower extends GenericModel
{
  public $validationRules = ['user_id' => "required|exists:users,id"];
  public $validationRuleNotRequired = ['follower_user_id'];
  public function systemGenerateValue($entry){
    if(isset($entry['user_id']) && config('payload.roles.100')){
    }
    $entry['follower_user_id'] = config('payload.id');
    return $entry;
  }
  public function follower_user(){
    return $this->belongsTo('App\User', 'follower_user_id', 'id');
  }
  public function user($key = "id"){
    return $this->belongsTo('App\User');
  }
}
