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
        'post_attachments' => [],
        'post_user_tags' => [
          'foreign_tables' => [
            'user' => [
              'foreign_tables' => [
                'user_basic_information' => [],
                'user_profile_picture' => [],
              ]
            ]
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
    }else{
      $resultObject['fail'] = [
        "code" => 1,
        "message" => $validation->validationErrors
      ];
    }
    if($resultObject['success'] && isset($entry['post_attachments']) && count($entry['post_attachments']) > 0){
      $uploadTicketResult = $this->requestUploadTicket(count($entry['post_attachments']), 'Post Upload');
      $resultObject['success']['upload_ticket_id'] = $uploadTicketResult['upload_ticket_id'];
      $resultObject['success']['upload_location'] = $uploadTicketResult['upload_location'];
    }else{
      $this->responseGenerator->addDebug('isset', isset($entry['post_attachments']));
      // $this->responseGenerator->addDebug('count', count($entry['post_attachments']));
    }
    $this->responseGenerator->setSuccess($resultObject['success']);
    $this->responseGenerator->setFail($resultObject['fail']);
    return $this->responseGenerator->generate();
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
    if($resultObject['success'] && isset($entry['post_attachments']) && count($entry['post_attachments']) > 0){
      $uploadTicketResult = $this->requestUploadTicket(count($entry['post_attachments']), 'Post Upload');
      $resultObject['success']['upload_ticket_id'] = $uploadTicketResult['upload_ticket_id'];
      $resultObject['success']['upload_location'] = $uploadTicketResult['upload_location'];
    }else{
      $this->responseGenerator->addDebug('isset', isset($entry['post_attachments']));
      // $this->responseGenerator->addDebug('count', count($entry['post_attachments']));
    }
    $this->responseGenerator->setSuccess($resultObject['success']);
    $this->responseGenerator->setFail($resultObject['fail']);
    return $this->responseGenerator->generate();
  }
}
