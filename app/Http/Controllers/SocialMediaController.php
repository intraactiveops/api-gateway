<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class SocialMediaController extends GenericController
{
  function __construct(){
    $this->model = new App\SocialMedia();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
}
