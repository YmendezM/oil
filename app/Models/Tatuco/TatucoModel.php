<?php

namespace App\Models\Tatuco;

use Illuminate\Database\Eloquent\Model;
use App\Traits\doWhereTrait;

class TatucoModel extends Model
{

    use doWhereTrait;

    protected $rules = [];

    protected $messages = [];

    protected $errors;

    /* public static function createNew($account = false)
     {
         $class = get_called_class();
         $model = new $class();
         $user = JWTAuth::parseToken()->authenticate();
         if($user && !$account){
             $model->account = $user->account;
         }else{
             $model->account = $account;
         }

         return $model;
     }*/

    public function validate($data)
    {
        $v = Validator::make($data, $this->rules, $this->messages);

        if($v->fails()){
            $this->errors = $v->messages();

            return false;
        }
        return true;
    }

    public function errors()
    {
        return $this->errors->toArray();
    }



}
