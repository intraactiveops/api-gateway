<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserContactController extends GenericController
{
  function __construct(){
    $this->model = new App\UserContact();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
        "user" => [
          "is_child" => false,
          'foreign_tables' => [
            'user_basic_information' => [
              'is_child' => true
            ]
          ]
        ],
        "contact_user" => [
          'true_table' => 'users',
          'is_child' => false,
          'foreign_tables' => [
            'user_basic_information' => [
              'is_child' => true
            ]
          ]
        ]
      ]
    ];
    $this->initGenericController();
  }
}
