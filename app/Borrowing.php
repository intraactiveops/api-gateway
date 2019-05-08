<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends GenericModel
{
    protected $validationRuleNoteRequired = ['note'];
}
