<?php

namespace Http\Models;

use Core\Model;
use Core\Validator;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function listValidationRules($data)
    {
        // validation rules
        $errors = null;
        if ( !Validator::nullable($data['perPage'], [Validator::class, 'number'])) {
            $errors['perPage'] = 'Please provide a number page count.';
        }   

        if (!Validator::nullable($data['page'], [Validator::class, 'number'])) {
            $errors['page'] = 'Please provide a number page';
        }

        if (isset($data['name']) && !Validator::nullable($data['name'], [Validator::class, 'string'])) {
            $errors['name'] = 'Please provide a string name';
        }
        if (isset($data['is_blocked']) && !Validator::nullable($data['is_blocked'], [Validator::class, 'number'])) {
            $errors['is_blocked'] = 'Please provide a number  is_blocked';
        }

        return $errors;
    }

    public function idValidationRule($id){
        $errors=null;
        if (!Validator::number($id)||!Validator::required($id)) {
            $errors['id'] = 'Please provide a number  id';
        }
        return $errors;
    }
    private function attributesValidationRules($data){
        $errors=null;
        if (!Validator::required($data->name) ||  !Validator::string($data->name)) {
            $errors['name'] = 'Please provide a string name';
        }
        if (!Validator::required($data->ip) || !Validator::string($data->ip)) {
            $errors['ip'] = 'Please provide a valid  ip';
        }

        return $errors;
    }
    public function createValidationRule($data)
    {
        $errors = $this->attributesValidationRules($data);        
        return $errors;
    }

    public function updateValidationRule($id,$data){

        $errors= $this->idValidationRule($id);
        if(isset($errors)){
            return $errors;
        }
        $errors=$this->attributesValidationRules($data);
        return $errors;
    }
    public function validateUserNameRule($data){
        $errors=null;
        if (!Validator::required($data->username) ||  !Validator::string($data->username)) {
            $errors['name'] = 'Please provide a string name';
        }
        return $errors;
    }
}
