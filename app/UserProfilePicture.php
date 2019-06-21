<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfilePicture extends GenericModel
{
  public $validationRuleNotRequired = ['file_name'];
  public function systemGenerateValue($entry){
    $entry['user_id'] = config('payload.id');
    return $entry;
  }
}
