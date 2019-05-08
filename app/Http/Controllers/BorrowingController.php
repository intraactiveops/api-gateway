<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class BorrowingController extends GenericController
{
  function __construct(){
    $this->model = new App\Borrowing();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
