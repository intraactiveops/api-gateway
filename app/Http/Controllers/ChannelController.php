<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ChannelController extends GenericController
{
  function __construct(){
    $this->model = new App\Channel();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
        'channel_participants' => [
          'validation_required' => true,
          'foreign_tables' => [
            'user' => [
              'foreign_tables' => [
                'user_basic_information' => []
              ]
            ]
          ]
        ],
        'channel_messages' => [
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
                'channel_message_post_people_tag' => []
              ]
            ]
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
    $validation->additionalRule = [
      'channel_participants' => 'required|array|min:1',
      'channel_messages' => 'required',
      'channel_messages.0.type' => 'required|in:1,2,3',
      'channel_messages.0.channel_message_post' => "required|array"
    ];
    if($validation->isValid($entry)){
      $entry['channel_messages'][0]['user_id'] = config('payload.id');
      $entry['channel_participants'] = $this->setChannelParticipantType($entry['channel_participants']);
      $genericCreate = new Core\GenericCreate($this->tableStructure, $this->model);
      $resultObject['success'] = $genericCreate->create($entry);
      if($resultObject['success'] && isset($entry['channel_messages'][0]['channel_message_post']['channel_message_post_attachments']) && count($entry['channel_messages'][0]['channel_message_post']['channel_message_post_attachments']) > 0){
        $uploadTicketResult = $this->requestUploadTicket(count($entry['channel_messages'][0]['channel_message_post']['channel_message_post_attachments']), 'Channel Message Message Post Upload');
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
  private function setChannelParticipantType($channelParticipants){
    foreach($channelParticipants as $key => $value){
      $channelParticipants[$key]['type'] = 1;
    }
    $channelParticipants[] = ['user_id' => config('payload.id'), 'type' => 1];
    return $channelParticipants;
  }

}
