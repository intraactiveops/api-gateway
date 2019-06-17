<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class BorrowerController extends GenericController
{
  function __construct(){
    $this->model = new App\Borrower();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
