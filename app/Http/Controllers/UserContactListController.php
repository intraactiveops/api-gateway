<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserContactListController extends GenericController
{
  function __construct(){
    $this->model = new App\UserContactList();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
        "contact_user_basic_information" => [
          'true_table' => 'user_basic_information'
        ]
      ]
    ];
    $this->initGenericController();
  }
}
