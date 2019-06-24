<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserOrganizationController extends GenericController
{
  function __construct(){
    $this->model = new App\UserOrganization();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
