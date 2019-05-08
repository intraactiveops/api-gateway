<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends GenericModel
{
    protected $validationRuleNoteRequired = ['note'];
}
