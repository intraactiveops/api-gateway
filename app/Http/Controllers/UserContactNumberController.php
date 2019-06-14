<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserContactNumberController extends GenericController
{
  function __construct(){
    $this->model = new App\UserContactNumber();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
