<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelMessage extends GenericModel
{
  protected $validationRuleNotRequired = ['user_id'];
  public function systemGenerateValue($entry){
    $entry['user_id'] = config('payload.id');
    return $entry;
  }
  public function channel_message_post(){
    return $this->hasOne('App\ChannelMessagePost');
  }
  public function user(){
    return $this->belongsTo('App\User');
  }
}
