<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends GenericModel
{
  public function systemGenerateValue($data){
    $data['is_predefined'] = 0;
    return $data;
  }
}
