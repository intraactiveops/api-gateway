<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ChannelMessageController extends GenericController
{
  function __construct(){
    $this->model = new App\ChannelMessage();
    $this->tableStructure = [
      'foreign_tables' => [
        'user' => [
          'foreign_tables' => [
            'user_basic_information' => []
          ]
        ],
        'channel_message_post' => [
          'is_child' => true,
          'validation_required' => false,
          'foreign_tables' => [
            'channel_message_post_attachments' => [],
            'channel_message_post_user_tags' => [
              'foreign_tables' => [
                'user' => [
                  'foreign_tables' => [
                    'user_basic_information' => []
                  ]
                ]
              ]
            ]
          ]
        ],
        'user' => [
          'foreign_tables' => [
            'user_basic_information' => [],
            'user_profile_picture' => []
          ]
        ],
      ]
    ];
    $this->initGenericController();
  }
  public function create(Request $request){
    $entry = $request->all();
    $resultObject = [
      "success" => false,
      "fail" => false
    ];
    $validation = new Core\GenericFormValidation($this->tableStructure, 'create');
    if($validation->isValid($entry)){
      $genericCreate = new Core\GenericCreate($this->tableStructure, $this->model);
      $resultObject['success'] = $genericCreate->create($entry);
      if($resultObject['success'] && isset($entry['channel_message_post']['channel_message_post_attachments']) && count($entry['channel_message_post']['channel_message_post_attachments']) > 0){
        $uploadTicketResult = $this->requestUploadTicket(count($entry['channel_message_post']['channel_message_post_attachments']), 'Channel Message Message Post Upload');
        $resultObject['success']['upload_ticket_id'] = $uploadTicketResult['upload_ticket_id'];
        $resultObject['success']['upload_location'] = $uploadTicketResult['upload_location'];
      }
    }else{
      $resultObject['fail'] = [
        "code" => 1,
        "message" => $validation->validationErrors
      ];
    }
    $this->responseGenerator->setSuccess($resultObject['success']);
    $this->responseGenerator->setFail($resultObject['fail']);
    return $this->responseGenerator->generate();
  }
}
