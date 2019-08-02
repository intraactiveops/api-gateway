<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
class ChannelMessagePostController extends GenericController
{
  function __construct(){
    $this->model = new App\ChannelMessagePost();
    $this->tableStructure = [
      'foreign_tables' => [
        'channel_message_post_attachments' => [],
        'channel_message_post_people_tag' => []
      ]
    ];
    $this->initGenericController();
  }
}
