<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends GenericModel
{
    protected $validationRuleNotRequired = ['note', 'datetime_paid'];
    public function systemGenerateValue($entry){
      if(isset($entry['datetime_paid']) && $entry['datetime_paid']){
        $entry['datetime_paid'] = date('Y-m-d H:i:s', time());
      }
      return $entry;
    }
    public function borrower(){
      return $this->belongsTo('App\Borrower');
    }
}
