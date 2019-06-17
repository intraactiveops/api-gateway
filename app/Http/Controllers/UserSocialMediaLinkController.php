<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserSocialMediaLinkController extends GenericController
{
  function __construct(){
    $this->model = new App\UserSocialMediaLink();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
