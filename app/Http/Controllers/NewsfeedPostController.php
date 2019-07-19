<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class NewsfeedPostController extends GenericController
{
  function __construct(){
    $this->model = new App\NewsfeedPost();
    $this->tableStructure = [
      'columns' => [],
      'foreign_tables' => [
        'post' => [
          'foreign_tables' => [
            'post_attachments' => [],
            'post_user_tags' => [
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
            'user_addresses' => [
              'region_country' => [],
              'region' => []
            ],
            'user_profile_picture' => []
          ]
        ]
      ]
    ];
    $this->initGenericController();
  }

  public function create(Request $request){
    $requestData = $request->all();

    $resultObject = [
      "success" => null,
      "fail" => false
    ];
    $this->model = new App\Post();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
        'newsfeed_post' => ['is_child' => true]
      ]
    ];
    $this->initGenericController();
    $validation = new Core\GenericFormValidation($this->tableStructure, 'create');
    $validation->additionalRule = [
      'attachments.*.size' => 'max:1000000'
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
    if($postResult = $genericCreate->create($requestData)){
      $this->model = new App\NewsfeedPost();
      $this->tableStructure = [];
      $this->initGenericController();
      $genericCreateNewsfeed = new Core\GenericCreate($this->tableStructure, $this->model);
      $newsfeedPostResult = $genericCreateNewsfeed->create([
        'post_id' => $postResult['id']
      ]);
      $newsfeedPostResult['post'] = ["id" => $postResult['id']];
      $this->responseGenerator->setSuccess($newsfeedPostResult);
    }

    return $this->responseGenerator->generate();
  }
}
