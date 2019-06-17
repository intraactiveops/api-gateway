<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserProfessionalActivityController extends GenericController
{
  function __construct(){
    $this->model = new App\UserProfessionalActivity();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
