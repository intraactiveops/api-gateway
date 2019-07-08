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
        // 'post_reactions' => [],
        // 'post_comments' => []
      ]
    ];
    $this->initGenericController();
  }
}
