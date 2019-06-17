<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class BorrowCycleController extends GenericController
{
  function __construct(){
    $this->model = new App\BorrowCycle();
    $this->tableStructure = [
      'columns' => [
      ],
      'foreign_tables' => [
      ]
    ];
    $this->initGenericController();
  }
  function end(Request $request){
    $entry = $request->all();
    if($entry['id']){
      $unPaidBorrowing = (new App\Borrowing())->where('datetime_paid', null)->where('borrow_cycle_id', $entry['id'])->count();
      if($unPaidBorrowing){
        $this->responseGenerator->setFail([
          'code' => 1,
          'message' => 'There are still ' . $unPaidBorrowing . ' unpaid borrowings'
        ]);
      }else{
        $this->createUpdateEntry($entry, 'update');
        $this->responseGenerator->setSuccess(true);
      }
    }
    return $this->responseGenerator->generate();
  }
}
