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
        'channel_message_post_user_tags' => [
          'foreign_tables' => [
            'user' => [
              'foreign_tables' => [
                'user_basic_information' => [],
                'user_profile_picture' => [],
              ]
            ]
          ]
        ]
      ]
    ];
    $this->initGenericController();
  }
  public function update(Request $request){
    $entry = $request->all();
    $resultObject = [
      "success" => false,
      "fail" => false
    ];
    $validation = new Core\GenericFormValidation($this->tableStructure, 'update');
    if($validation->isValid($entry)){
        $genericUpdate = new Core\GenericUpdate($this->tableStructure, $this->model);
        $resultObject['success'] = $genericUpdate->update($entry);
    }else{
      $resultObject['fail'] = [
        "code" => 1,
        "message" => $validation->validationErrors
      ];
    }
    if($resultObject['success'] && isset($entry['channel_message_post_attachments']) && count($entry['channel_message_post_attachments']) > 0){
      $uploadTicketResult = $this->requestUploadTicket(count($entry['channel_message_post_attachments']), 'Post Upload');
      $resultObject['success']['upload_ticket_id'] = $uploadTicketResult['upload_ticket_id'];
      $resultObject['success']['upload_location'] = $uploadTicketResult['upload_location'];
    }else{
      $this->responseGenerator->addDebug('isset', isset($entry['channel_message_post_attachments']));
      // $this->responseGenerator->addDebug('count', count($entry['post_attachments']));
    }
    $this->responseGenerator->setSuccess($resultObject['success']);
    $this->responseGenerator->setFail($resultObject['fail']);
    return $this->responseGenerator->generate();
  }
}
