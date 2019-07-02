<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsfeedPost extends GenericModel
{
  protected $validationRuleNotRequired = ['user_id'];
  public function systemGenerateValue($entry){
    $entry['user_id'] = config('payload.id');
    return $entry;
  }
  public function post()
  {
      return $this->belongsTo('App\Post');
  }
  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
