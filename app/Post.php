<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends GenericModel
{
  protected $validationRuleNotRequired = ['posted_from_address'];
  public function post_reactions()
  {
      return $this->hasMany('App\PostReaction');
  }
  public function post_comments()
  {
      return $this->hasMany('App\PostComments');
  }
}
