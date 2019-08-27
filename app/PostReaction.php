<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends GenericModel
{
  protected $validationRuleNotRequired = ['user_id', 'reaction'];
  public function systemGenerateValue($entry){
    $entry['user_id'] = $this->userSession('id');
    $entry['reaction'] = isset($entry['reaction']) ? $entry['reaction'] : 1;
    return $entry;
  }
}
