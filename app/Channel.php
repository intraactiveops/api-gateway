<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends GenericModel
{
  public function channel_participants(){
    return $this->hasMany('App\ChannelParticipant');
  }
  public function channel_messages(){
    return $this->hasMany('App\ChannelMessage');
  }
}
