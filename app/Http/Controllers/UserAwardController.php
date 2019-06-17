<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserAwardController extends GenericController
{
  function __construct(){
    $this->model = new App\UserAward();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
