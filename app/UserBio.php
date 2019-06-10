<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBio extends GenericModel
{
  protected $validationRules = ["content" => "required|min:5"];
}
