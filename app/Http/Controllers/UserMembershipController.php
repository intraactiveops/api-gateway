<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserMembershipController extends GenericController
{
  function __construct(){
    $this->model = new App\UserMembership();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
