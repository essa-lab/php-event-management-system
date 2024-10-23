<?php

namespace Http\Controllers;
use Http\Models\Participant;

class ParticipantController extends Controller{

    //list of participants
    public function index(){
        
        $perPage = $this->request->input('perPage',5) ;
        $page =  $this->request->input('page',1);

        $participants = new Participant();
        $errors = $participants->listValidationRules($this->request->all());
        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }
        

        //search funcitonality
        if($this->request->has('name') && $this->request->input('name')){
           $participants =  $participants->where('name','like','%'.$this->request->input('name').'%');
        }
        if($this->request->has('phone_number') && $this->request->input('phone_number')){
           $participants =  $participants->where('phone_number','like','%'.$this->request->input('phone_number').'%');
        }


        //execute query
        $participants = $participants->paginate($perPage,$page);
        if(count($participants['data'] )== 0 ){
            return $this->response->error('Nothing To Show',404);
        }
        return $this->response->json(['message' => 'participants Fetched Succesfuly','item'=>$participants,'statusCode'=>200]);
    }

    // get the data for specific participant id
    public function read($id){
        $participant= new Participant();
        //validation rules
        $errors = $participant->idValidationRule($id);
        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //prepare and execute query
        $participant = $participant->find($id);
        if(!isset($participant)){
            return $this->response->error('participant Not Found',404);

        }

        return $this->response->json(['message' => 'participant Fetched Succesfuly','item'=>$participant->get(),'statusCode'=>200]);


    }

    // create new participant
    public function create(){
        $participantData = $this->request->all();
        $participant = new Participant();

        //validation rule
        $errors = $participant->createValidationRule($participantData);

        //validation error
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //prepare quest
        $participant->setAttributes([
            'name'=>$participantData->name,
            'phone_number'=>$participantData->phone_number,
        ]);
        //execute query
        $participant->save();

        return $this->response->json(['message' => 'participant Created Succesfuly','statusCode'=>200]);

    }

    // update participant record
    public function update($id){
        $participantData = $this->request->all();
        $participant = new Participant();
        //validation rule
        $errors = $participant->updateValidationRule($id,$participantData);
        //validation error
        if(!empty($this->errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$this->errors],403);
        }


        //check if the given id for an participant exsist
        $participant = $participant->find($id);
        if(empty($participant)){
            return $this->response->error('participant Not Found',404);
        }

        //prepare query
        $participant->setAttributes([
            'id'=>$id,
            'name'=>$participantData->name,
            'phone_number'=>$participantData->phone_number,
        ]);
        //execute query
        $participant->save();

        return $this->response->json(['message' => 'participant Updated Succesfuly','statusCode'=>200]);

    }

    
    // delete participatn
    public function delete($id){
        $participant = new Participant();
        //validation rule
        $errors = $participant->idValidationRule($id);
        //validation error
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }


        //prepare and execute query
        $participant = $participant->find($id);

        //if not found return error
        if(empty($participant)){
            return $this->response->error('participant Not Found',404);
        }

        //delet query execuation
        if($participant->delete()){
            return $this->response->json(['message' => 'participant Deleted Succesfuly','statusCode'=>200]);
        }
        return $this->response->json(['message' => 'participant Not Found','statusCode'=>404]);

    }
    
    // function to fill a frontend select element
    public function participantForSelect(){
        $participants = (new Participant())::all();

        return $this->response->json(['message'=>'ok','participants'=>$participants]);
  
    }
}