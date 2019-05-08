<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBasicInformation extends GenericModel
{
    protected $table = 'user_basic_informations';
    protected $validationRuleNotRequired = ['birthdate', 'middle_name'];
    protected $formulatedColumn = [
      'full_name' => "CONCAT(last_name, ', ', first_name)",
      'full_address' => "CONCAT(address, ', ', city, ', ', province)"
    ];
    public function systemGenerateValue($entry){
      if(!isset($netry['id']) || $entry['id'] == null){
        $entry['middle_name'] = '';
      }
      return $entry;
    }
}
