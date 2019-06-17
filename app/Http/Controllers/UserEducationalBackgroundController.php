<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserEducationalBackgroundController extends GenericController
{
  function __construct(){
    $this->model = new App\UserEducationalBackground();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
