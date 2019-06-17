<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowCycle extends GenericModel
{
    protected $validationRuleNotRequired = ['datetime_ended', 'name'];
    public function systemGenerateValue($entry){
      if(isset($entry['datetime_ended']) && $entry['datetime_ended'] == 'SYSTEM_DATETIME'){
        $entry['datetime_ended'] = date('Y-m-d H:i:s', time());
      }
      return $entry;
    }
}
