<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class PostController extends GenericController
{
  function __construct(){
    $this->model = new App\Post();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
        'newsfeed_post' => [],
        'post_user_tags' => [
          'foreign_tables' => [
          ]
        ],
        'user' => [
          'foreign_tables' => [
            'user_basic_information' => [],
            'user_profile_picture' => [],
          ]
        ]
        // 'post_reactions' => [],
        // 'post_comments' => []
      ]
    ];
    $this->initGenericController();
  }
}
