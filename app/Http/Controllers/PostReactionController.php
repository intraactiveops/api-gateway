<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class PostReactionController extends GenericController
{
  function __construct(){
    $this->model = new App\PostReaction();
    $this->tableStructure = [
      'columns' => [
      ]
    ];
    $this->deleteWithUserId = true;
    $this->initGenericController();
  }
  public function create(Request $request){
    $requestData = $request->all();
    $resultObject = [
      "success" => false,
      "fail" => false
    ];
    $validation = new Core\GenericFormValidation($this->tableStructure, 'create');

    if($validation->isValid($requestData)){
      $retrieveParam = [
        'select' => ['id'],
        'condition' => [[
          'post_id' => $requestData['post_id']
        ]]
      ];
      $deleteParam = [[
        'column' => 'post_id',
        'value' => $requestData['post_id']
      ], [
        'column' => 'user_id',
        'value' => $this->userSession()
      ]];
      $this->deleteEntry(null, $deleteParam);
      $genericCreate = new Core\GenericCreate($this->tableStructure, $this->model);
      $resultObject['success'] = $genericCreate->create($requestData);
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
