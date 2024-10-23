<?php

namespace Http\Models;

use Core\Model;
use Core\Validator;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'event_id';

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

        if (isset($data['event_title']) && !Validator::nullable($data['event_title'], [Validator::class, 'string'])) {
            $errors['event_title'] = 'Please provide a string event_title';
        }
        if (isset($data['start_date']) && !Validator::nullable($data['start_date'], [Validator::class, 'date'])) {
            $errors['start_date'] = 'Please provide a valid  start_date';
        }
        if (isset($data['end_date']) && !Validator::nullable($data['end_date'], [Validator::class, 'date'])) {
            $errors['end_date'] = 'Please provide a valid  end_date';
        }

        if (isset($data['location_id']) && !Validator::nullable($data['location_id'], [Validator::class, 'number'])) {
            $errors['location_id'] = 'Please provide a number  location_id';
        }

        if (isset($data['start_date']) && isset($data['end_date']) && !Validator::isDateGreater($data['end_date'], $data['start_date'])) {
            $errors['greater_than'] = 'make sure end_date to be after start_date';
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
        if (!Validator::required($data->event_title) ||  !Validator::string($data->event_title)) {
            $errors['event_title'] = 'Please provide a string event_title';
        }
        if (!Validator::required($data->start_date) || !Validator::date($data->start_date)) {
            $errors['start_date'] = 'Please provide a valid  start_date';
        }
        if (!Validator::required($data->end_date) || !Validator::date($data->end_date)) {
            $errors['end_date'] = 'Please provide a valid  end_date';
        }

        if (!Validator::isDateGreater($data->end_date, $data->start_date)) {

            $errors['greater_than'] = 'make sure end_date to be after start_date';
        }

        if (!Validator::number($data->location_id) || !Validator::required($data->location_id)) {
            $errors['location_id'] = 'Please provide a number  location_id';
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
}
