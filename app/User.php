<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends GenericModel
{
    protected $hidden = array('password');
    // protected $fillable = ['user_id', 'first_name', 'middle_name', 'last_name', 'mobile_number', 'gender', 'birthdate', 'occupation'];
    protected $validationRules = [
      'email' => 'required|email|unique:users,email,except,id',
      'password' => 'required|min:4',
      'user_type_id' => 'numeric'
    ];
    protected $defaultValue = [
      'middle_name' => ''
    ];
    protected $validationRuleNotRequired = ['username', 'middle_name', 'status', 'user_type_id'];
    public function systemGenerateValue($data){
      (isset($data['email'])) ? $data['username'] = $data['email'] : null;
      (isset($data['password'])) ? $data['password'] = Hash::make($data['password']) : null;
      $data['user_type_id'] = $this->user('user_type_id') * 1 >= 10 ? $data['user_type_id'] : 10;
      if(!isset($data['id']) || $data['id'] == 0){ // if create
        $data['status'] = 0;
      }
      return $data;
    }
    public function company_users()
    {
        return $this->hasOne('App\CompanyUser');
    }
    public function user_basic_information()
    {
        return $this->hasOne('App\UserBasicInformation');
    }
    public function user_bank_account()
    {
        return $this->hasOne('App\userBankAccount')->orderBy('created_at', 'desc');
    }
}
