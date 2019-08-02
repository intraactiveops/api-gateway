<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelParticipant extends GenericModel
{
  public function systemGenerateValue($entry){
    return $entry;
  }
  public function user(){
    return $this->belongsTo('App\User');
  }
  public function channel(){
    return $this->belongsTo('App\Channel');
  }
}
