<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
class RoleController extends GenericController
{
  function __construct(){
    $this->model = new App\Role();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
