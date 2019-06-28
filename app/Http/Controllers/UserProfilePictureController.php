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
      'original_picture.size' => 'numeric|max:5000000', // 5MB
      'original_picture.type' => 'in:image/jpg,image/jpeg,image/png',
      'cropped_picture.size' => 'required|numeric|max:1000000', // 1MB
      'cropped_picture.type' => 'required|in:png',
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
          "expected_file_quantity" => 2,
          "note" => 'profile picture'
        ];
        $client = new Client(); //GuzzleHttp\Client
          $result = $client->request('POST', env('FILE_SERVER').'/v1/get-ticket', [
          'json' => $param
        ]);
        $result = json_decode((string)$result->getBody(), true);
        $resultObject['success']['upload_ticket_id'] = $result['data']['id'];
        $resultObject['success']['upload_location'] = $result['data']['location'];
        $this->responseGenerator->setSuccess($resultObject['success']);
      } catch (GuzzleException $e) {
        // echo getenv('FILE_SERVER').'/v1/get-ticket';
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
  public function update(Request $request){
    if(!$this->checkAuthenticationRequirement($this->basicOperationAuthRequired["update"])){
      return $this->responseGenerator->generate();
    }
    $requestData = $request->all();
    $resultObject = $this->createUpdateEntry($requestData, "update");
    $this->responseGenerator->setSuccess($resultObject['success']);
    $this->responseGenerator->setFail($resultObject['fail']);
    if($resultObject['success']){
      (new App\UserProfilePicture())->where("id", '!=', $request->input('id'))->where('user_id', config('payload.id'))->delete();
    }
    return $this->responseGenerator->generate();
  }
}
