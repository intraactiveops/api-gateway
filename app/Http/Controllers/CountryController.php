<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class CountryController extends GenericController
{
  function __construct(){
    $this->model = new App\Country();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
