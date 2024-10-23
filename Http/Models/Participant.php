<?php

namespace Http\Models;
use Core\Model;
use Core\Validator;

class Participant extends Model{
    protected $table = 'participants';
    
    public function listValidationRules($data)
    {
        // validation rules
        $errors = null;
        if (isset($data['perPage'])&&!Validator::nullable($data['perPage'], [Validator::class, 'number'])) {
            $errors['perPage'] = 'Please provide a number page count.';
        }

        if (isset($data['page'])&&!Validator::nullable($data['page'], [Validator::class, 'number'])) {
            $errors['page'] = 'Please provide a number page';
        }

        if (isset($data['name'])&&!Validator::nullable($data['name'], [Validator::class, 'string'])) {
            $errors['name'] = 'Please provide a string name';
        }
        if (isset($data['phone_number'])&&!Validator::nullable($data['phone_number'], [Validator::class, 'string'])) {
            $errors['phone_number'] = 'Please provide a string phone_number';
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
        if (!Validator::required($data->phone_number) ||  !Validator::string($data->phone_number)) {
            $errors['phone_number'] = 'Please provide a string phone_number';
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
        return $data;
    }
    
}