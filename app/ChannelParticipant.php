<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelParticipant extends GenericModel
{
  public $validationRuleNotRequired = ['type'];
  public function systemGenerateValue($entry){
    if(!isset($entry['type'])){
      $entry['type'] = 0;
    }
    return $entry;
  }
  public function user(){
    return $this->belongsTo('App\User');
  }
  public function channel(){
    return $this->belongsTo('App\Channel');
  }
}
