<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class BorrowCycleController extends GenericController
{
  function __construct(){
    $this->model = new App\BorrowCycle();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
