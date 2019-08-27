<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostAttachment extends GenericModel
{
    protected $validationRuleNotRequired = ['type', 'name', 'file_name', 'preview_file_name'];
}
