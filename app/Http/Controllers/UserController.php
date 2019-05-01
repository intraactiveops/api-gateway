<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App;
class UserController extends GenericController
{
    function __construct(){
      $this->model = new App\User();
      $this->tableStructure = [
        'columns' => [
        ],
        'foreign_tables' => [
          'user_basic_information' => ['is_child' => true, 'validation_required' => true]
        ]
      ];
      $this->initGenericController();
      // $this->retrieveCustomQueryModel = function($queryModel){
      //   if($this->user('user_type_id') >= 10){
      //     $queryModel = $queryModel->join('company_users', 'company_users.user_id', '=', 'users.id');
      //     return $queryModel->where('company_users.company_id', $this->user('company_id'));
      //   }else{
      //     return $queryModel;
      //   }
      // };
    }
    public function create(Request $request){
      // printR($request->all());

      $entry = $request->all();
      $entry['user_type_id'] = config('payload.user_type_id') == null || config('payload.user_type_id') >= 10 ? 10 : $entry['user_type_id'];
      $validation = new Core\GenericFormValidation($this->tableStructure, 'create');
      if($entry['user_type_id'] >= 10 && config('payload.user_type_id') == null){
        $validation->additionalRule = ['company_code' => 'required|exists:companies,code'];
      }else{
        $validation->additionalRule = ['company_id' => 'required|exists:companies,id'];
      }
    // printR($entry);

      if($validation->isValid($entry)){
        $genericCreate = new Core\GenericCreate($this->tableStructure, $this->model);
        $userResult = $genericCreate->create($entry);
        if($userResult['id']){ // create company user
          $this->model = new App\CompanyUser();
          $this->tableStructure = [];
          $this->initGenericController();
          $genericCreate = new Core\GenericCreate($this->tableStructure, $this->model);
          $companyID =  config('payload.user_type_id') == null || config('payload.user_type_id') >= 10 ? config('payload.company_id') : $entry['company_id'];
          if($entry['user_type_id'] >= 10 && config('payload.user_type_id') == null){
            $company = (new App\Company())->where('code', $entry['company_code'])->get()->first()->toArray();
            $companyID = $company['id'];
          }
          $companyRoleEntry = [
            'company_id' => $companyID,
            'user_id' => $userResult['id'],
            'status' => 4 // not verified
          ];
          $companyRoleResult = $genericCreate->create($companyRoleEntry);
          if($companyRoleResult['id']){
            $this->responseGenerator->setSuccess([
              'id' => $userResult['id'],
              'company_user_id' => $companyRoleResult['id']
            ]);
          }
        }else{
          $this->responseGenerator->setSuccess([
            'id' => $userResult['id']
          ]);
        }
      }else{
        $this->responseGenerator->setFail([
          "code" => 1,
          "message" => $validation->validationErrors
        ]);
      }
      return $this->responseGenerator->generate();
    }


    public function changePassword(Request $request){
      if(!auth()->user()){
        $this->responseGenerator->setFail(["code" => 2, "message" => "Not Logged In"]);
        return $this->responseGenerator->generate();
      }
      $requestArray = $request->all();
      $validationRules = $this->model->getValidationRule();
      $validator = Validator::make($requestArray, [
        "current_password" => "required|".$validationRules['password'],
        "new_password" => "required|".$validationRules['password']
      ]);
      if($validator->fails()){
        $validator->errors()->toArray();
        $this->responseGenerator->setFail([
          "code" => 1,
          "message" => $validator->errors()->toArray()
        ]);
        return $this->responseGenerator->generate();
      }
      $user = auth()->user()->toArray();
      if(Auth::validate(["email" => $user['email'], "password" => $requestArray["current_password"]])){
        $result = $this->model->updateEntry($user['id'], ["password" => $requestArray["new_password"] ]);
        $this->responseGenerator->setSuccess($result);
      }else{
        $this->responseGenerator->setFail([
          "code" => 10,
          "message" => 'Current Password Incorrect'
        ]);
      }
      return $this->responseGenerator->generate();

    }
}
