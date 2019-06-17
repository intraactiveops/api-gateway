<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class CityController extends GenericController
{
  function __construct(){
    $this->model = new App\City();
    $this->tableStructure = [
      'columns' => [
      ]
    ];
    $this->initGenericController();
  }
}
