<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserFollowerController extends GenericController
{
  function __construct(){
    $this->model = new App\UserFollower();
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
        "follower_user" => [
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
