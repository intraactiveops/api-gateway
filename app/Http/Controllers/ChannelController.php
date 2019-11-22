<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
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
                'user_basic_information' => [],
                'user_profile_picture' => []
              ]
            ]
          ]
        ],
        'channel_messages' => [
          'foreign_tables' => [
            'user' => [
              'foreign_tables' => [
                'user_basic_information' => [],
                'user_profile_picture' => []
              ]
            ],
            'channel_message_post' => [
              'is_child' => true,
              'validation_required' => false,
              'foreign_tables' => [
                'channel_message_post_attachments' => [],
                'channel_message_post_user_tags' => [
                  "is_child" => true,
                  'foreign_tables' => [
                    'user' => [
                      'foreign_tables' => [
                        'user_basic_information' => [],
                        'user_profile_picture' => []
                      ]
                    ]
                  ]
                ]
              ]
            ]
          ]
        ],

      ]
    ];
    $this->retrieveCustomQueryModel = function($queryModel, &$leftJoinedTable){
      $leftJoinedTable[] = 'channel_participants';
      $queryModel = $queryModel->join('channel_participants', "channels.id", "=", "channel_participants.channel_id");
      $queryModel = $queryModel->where('channel_participants.user_id', $this->userSession());
      return $queryModel;
    };
    $this->initGenericController();
  }
  public function create(Request $request){
    $requestArray = $request->all();
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
    if($validation->isValid($requestArray)){
      $requestArray['channel_messages'][0]['user_id'] = config('payload.id');
      $requestArray['channel_participants'] = $this->setChannelParticipantType($requestArray['channel_participants']);
      $genericCreate = new Core\GenericCreate($this->tableStructure, $this->model);
      $resultObject['success'] = $genericCreate->create($requestArray);
      if($resultObject['success'] && isset($requestArray['channel_messages'][0]['channel_message_post']['channel_message_post_attachments']) && count($requestArray['channel_messages'][0]['channel_message_post']['channel_message_post_attachments']) > 0){
        $uploadTicketResult = $this->requestUploadTicket(count($requestArray['channel_messages'][0]['channel_message_post']['channel_message_post_attachments']), 'Channel Message Message Post Upload');
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
  public function search(Request $request){
    $requestArray = $request->all();
    $validator = Validator::make($requestArray, [
      // 'keyword' => 'required',
      'limit' => 'numeric|max:30',
      "select" => "required|array|min:1"
    ]);
    if($validator->fails()){
      $this->responseGenerator->setFail([
        "code" => 1,
        "message" => $validator->errors()->toArray()
      ]);
      return $this->responseGenerator->generate();
    }

    $resultLimit = isset($requestArray['limit']) ? $requestArray['limit'] : 10;
    $resultOffset = isset($requestArray['offset']) ? $requestArray['offset'] : 0;
    unset($requestArray['offset']);
    unset($requestArray['limit']);
    $searchText = 'CONCAT(channels.title, " ",GROUP_CONCAT(user_basic_informations.first_name, " ", user_basic_informations.last_name, " "))';
    $this->model = $this->model->select(DB::raw($searchText.' as search_text'));
    $this->model->addSelect('own_channel_participant.user_id');
    $this->model->addSelect('channels.id');
    $this->model->addSelect('channels.title');
    $this->model->addSelect('channels.updated_at');


    $this->model = $this->model->join('channel_participants', function ($join) {
        $join->on( 'channel_participants.channel_id', '=', 'channels.id')->distinct('channel_participants.user_id')->orderBy('channel_participants.id');
    });
    $this->model->join('channel_participants as own_channel_participant', function ($join) {
        $join->where('own_channel_participant.deleted_at', null);
        $join->on('own_channel_participant.channel_id', '=', 'channels.id')->on('own_channel_participant.user_id', '=', DB::raw(config('payload.id')));
    });
    $this->model->addSelect('own_channel_participant.channel_id');
    $this->model->addSelect('own_channel_participant.user_id as oc_user_id');
    $this->model = $this->model->join('user_basic_informations', 'user_basic_informations.user_id', '=', 'channel_participants.user_id');
    $this->model = $this->model->groupBy('channel_participants.channel_id');
    $this->model = $this->model->groupBy('channel_participants.user_id');
    $this->model = $this->model->groupBy('own_channel_participant.channel_id');
    $this->model->where('own_channel_participant.user_id', DB::raw(config('payload.id')));
    $currentResultCount = 0;
    $allResult = [];
    // $this->initPermutation();
    $this->model = $this->model->offset($resultOffset);
    $this->model = $this->model->limit($resultLimit);
    $this->model->orderBy('channels.id', 'desc');
    if($requestArray['keyword'] && $requestArray['keyword'] != ''){
      $keyWordPermutations = explode(" ", $requestArray['keyword']);
      for($x = 0; $x < count($keyWordPermutations); $x++){
        $this->model = $this->model->orHaving(DB::raw($searchText), 'like', '%'.$keyWordPermutations[$x] . '%');
      }
    }
    unset($requestArray['keyword']);
    $allResult = collect($this->model->distinct('id')->get()->toArray()); //->pluck('id');
    // printR($allResult);
    $allResult = $allResult->pluck('id');
    $this->responseGenerator->addDebug('rez', $allResult);
    $this->responseGenerator->addDebug('$resultOffset', $resultOffset);
    $this->model = new App\Channel();
    $this->model->orderBy('id', 'asc');
    if(isset($requestArray['condition'])){
      $requestArray['condition'] = [];
    }
    $requestArray['condition'][] = [
      "column" => "id",
      "clause" => "in",
      "value" => $allResult
    ];
    if($resultOffset){
      unset($requestArray['offset']);
    }
    // $model->join('channel_participants as own_channel_participant', function ($join) {
    //   echo 'yawa';
    //   $join->on('own_channel_participant.channel_id', '=', 'channels.id')->on('own_channel_participant.user_id', '=', DB::raw(config('payload.id')));
    // });

    $genericRetrieve = new Core\GenericRetrieve($this->tableStructure, $this->model, $requestArray);

    $this->responseGenerator->setSuccess($genericRetrieve->executeQuery());
    if($genericRetrieve->totalResult != null){
      $this->responseGenerator->setTotalResult($genericRetrieve->totalResult);
    }
    return $this->responseGenerator->generate();
  }
  private function searchSet($keyword, $model, $allResult, $resultLimit){
    $model->having(DB::raw('search_text'), 'like', $keyword);
    $model = $model->whereNotIn('channels.id', $allResult);
    return $model->limit($resultLimit - count($allResult))->get()->toArray();
  }
  private function initPermutation(){
    Collection::macro('permute', function () {
        if ($this->isEmpty()) {
            return new static([[]]);
        }

        return $this->flatMap(function ($value, $index) {
            return (new static($this))
                ->forget($index)
                ->values()
                ->permute()
                ->map(function ($item) use ($value) {
                    return (new static($item))->prepend($value);
                });
        });
    });
  }

}
