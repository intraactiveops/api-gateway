<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Config;
use App;

class UserProfilePictureController extends GenericController
{
  function __construct(){
    $this->model = new App\UserProfilePicture();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
  public function create(Request $request){
    $requestData = $request->all();
    // $resultObject = $this->createUpdateEntry($requestData);
    $resultObject = [
      "success" => false,
      "fail" => false
    ];
    $validation = new Core\GenericFormValidation($this->tableStructure, 'create');
    $validation->additionalRule = [
      'image_size' => 'required|max:1000000', // 1MB
      'image_type' => 'required|in:jpg,jpeg,png',
    ];
    if(!$validation->isValid($requestData)){
      $resultObject['fail'] = [
        "code" => 1,
        "message" => $validation->validationErrors
      ];
      $this->responseGenerator->setFail($resultObject['fail']);
      return $this->responseGenerator->generate();
    }

    $genericCreate = new Core\GenericCreate($this->tableStructure, $this->model);
    $resultObject['success'] = $genericCreate->create($requestData);
    if($resultObject['success']){
      try {
        $param = [
          "expected_file_quantity" => 1,
          "note" => 'profile picture'
        ];
        $client = new Client(); //GuzzleHttp\Client
          $result = $client->request('POST', env('FILE_SERVER').'/v1/get-ticket', [
          'json' => $param
        ]);
        $result = json_decode((string)$result->getBody(), true);
        $resultObject['success']['ticket_id'] = $result['data']['id'];
        $resultObject['success']['upload_location'] = $result['data']['location'];
        $this->responseGenerator->setSuccess($resultObject['success']);

      } catch (GuzzleException $e) {
        if($e->getResponse()->getStatusCode() == 422){ // validation error
          $response = json_decode((string)$e->getResponse()->getBody(), true);
          $this->responseGenerator->setFail(['code' => 422, "message" => $response]);
        }
      }
    }else{
      $this->responseGenerator->setSuccess($resultObject['success']);
      $this->responseGenerator->setFail($resultObject['fail']);
    }
    return $this->responseGenerator->generate();
  }
}
