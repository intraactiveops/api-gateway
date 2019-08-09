<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelMessagePost extends GenericModel
{
  public function channel_message_post_attachments(){
    return $this->hasMany('App\ChannelMessagePostAttachment');
  }
}
