<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComment extends GenericModel
{
    protected $validationRuleNotRequired = ['user_id', 'post_comment_id'];
    public function systemGenerateValue($entry){
      $entry['user_id'] = $this->userSession();
      return $entry;
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
