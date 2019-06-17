<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class RegionController extends GenericController
{
  function __construct(){
    $this->model = new App\Region();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
