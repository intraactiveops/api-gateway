<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelMessagePostAttachment extends GenericModel
{
    protected $validationRuleNotRequired = ['type', 'name', 'file_name', 'preview_file_name'];
}
