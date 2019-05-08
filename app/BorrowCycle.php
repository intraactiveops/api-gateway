<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowCycle extends GenericModel
{
    protected $validationRuleNotRequired = ['datetime_ended', 'name']
}
