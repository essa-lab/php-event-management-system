<?php

namespace Http\Models;
use Core\Model;
use Core\Validator;

class EventParticipant extends Model{
    protected $table = "event_participants";
    
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

        if (isset($data['location_id'])&&!Validator::nullable($data['location_id'], [Validator::class, 'number'])) {
            $errors['location_id'] = 'Please provide a string location_id';
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

        if (!Validator::number($data->event_id) || !Validator::required($data->event_id)) {
            $errors['event_id'] = 'Please provide a number  event_id';
        }
        if (!Validator::number($data->participant_id) || !Validator::required($data->participant_id)) {
            $errors['participant_id'] = 'Please provide a number  participant_id';
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