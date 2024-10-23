<?php

namespace Http\Models;
use Core\Model;
use Core\Validator;

class Location extends Model{
    protected $table = 'locations';
    
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

        if (isset($data['location_name'])&&!Validator::nullable($data['location_name'], [Validator::class, 'string'])) {
            $errors['location_name'] = 'Please provide a string location_name';
        }
        if (isset($data['address'])&&!Validator::nullable($data['address'], [Validator::class, 'string'])) {
            $errors['address'] = 'Please provide a string address';
        }

        if (isset($data['capacity'])&&!Validator::nullable($data['capacity'], [Validator::class, 'number'])) {
            $errors['capacity'] = 'Please provide a number  capacity';
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
        if (!Validator::required($data->location_name) ||  !Validator::string($data->location_name)) {
            $errors['location_name'] = 'Please provide a string location_name';
        }
        if (!Validator::required($data->address) ||  !Validator::string($data->address)) {
            $errors['address'] = 'Please provide a string address';
        }
        if (!Validator::number($data->capacity) || !Validator::required($data->capacity)) {
            $errors['capacity'] = 'Please provide a number  capacity';
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