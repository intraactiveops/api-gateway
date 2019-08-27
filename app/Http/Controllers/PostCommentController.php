<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class PostCommentController extends GenericController
{
  function __construct(){
    $this->model = new App\PostComment();
    $this->tableStructure = [
      'columns' => [
      ]
    ];
    $this->deleteWithUserId = true;
    $this->initGenericController();
  }
}
