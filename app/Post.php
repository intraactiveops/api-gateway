<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends GenericModel
{
  protected $validationRuleNotRequired = ['title', 'text', 'posted_from_address'];
  public function post_reactions()
  {
    return $this->hasMany('App\PostReaction');
  }
  public function post_comments()
  {
    return $this->hasMany('App\PostComment');
  }
  public function post_user_tags()
  {
    return $this->hasMany('App\PostUserTag');
  }
  public function post_attachments()
  {
    return $this->hasMany('App\PostAttachment');
  }
  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
