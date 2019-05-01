<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api_resource = function($apiResource){
  $apiResources = (is_array($apiResource))? $apiResource : [$apiResource];
  foreach($apiResources as $apiResourceValue){
    $pascalCase = preg_replace_callback("/(?:^|_)([a-z])/", function($matches) {
        return strtoupper($matches[1]);
    }, $apiResourceValue) . 'Controller';
    Route::get($apiResourceValue."/",$pascalCase."@index");
    Route::get($apiResourceValue."/test",$pascalCase."@test");
    Route::post($apiResourceValue."/create",$pascalCase."@create");
    Route::post($apiResourceValue."/retrieve",$pascalCase."@retrieve");
    Route::post($apiResourceValue."/update",$pascalCase."@update");
    Route::post($apiResourceValue."/delete",$pascalCase."@delete");
  }
};


Route::get('/', function(){
  echo str_plural('registry');
  echo 'API GET';
});


$apiResource = [
  'user',
  'role',
  'user_role',
  'user_access_list',
  'role_access_list',
  'service',
  'service_action',
  'company'
];
$api_resource($apiResource);