<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelMessagePostUserTag extends GenericModel
{
  public function user()
  {
      return $this->belongsTo('App\User');
  }
  public function user_information()
  {
      return $this->belongsTo('App\UserInformation', 'user_id', 'user_id');
  }
}
