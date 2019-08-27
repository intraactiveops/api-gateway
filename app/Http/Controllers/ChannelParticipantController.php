<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ChannelParticipantController extends GenericController
{
  function __construct(){
    $this->model = new App\ChannelParticipant();
    $this->tableStructure = [
      'foreign_tables' => [
        'user' => [
          'foreign_tables' > [
            'user_basic_information' => []
          ]
        ]
      ]
    ];
    $this->initGenericController();
  }
}
