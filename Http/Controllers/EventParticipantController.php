<?php

namespace Http\Controllers;
use Http\Models\EventParticipant;

class EventParticipantController extends Controller{

    // list of all the event participant
    public function index(){
        
        $perPage = $this->request->input('perPage',5) ;
        $page =  $this->request->input('page',1);

        $eventParticipant = new EventParticipant();
        //validation rule
        $errors=$eventParticipant->listValidationRules($this->request->all());
        //validation erros
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }
        

        //search funcitonality
        if($this->request->has('location_id') && $this->request->input('location_id')){
           $eventParticipant =  $eventParticipant->where('','like','%'.$this->request->input('event_title').'%');
        }

        //prepare query
        // select important field to display
        //join event tabel to get the event name
        // join location table to get the location name , address and capacit
        //group the result to get the total participants in each event
        $eventParticipant= $eventParticipant->select([
            'e.event_id','l.location_name','l.address','l.capacity','e.title','COUNT(event_participants.participant_id) AS total_participants'
        ])->join('events as e','event_participants.event_id','=','e.event_id')
          ->join('locations as l','e.location_id','=','l.id')
          ->groupBy(['e.event_id','l.location_name','l.address','e.title','l.capacity']);

        //execute the query
        $eventParticipant = $eventParticipant->paginate($perPage,$page);
        if(count($eventParticipant['data'] )== 0 ){
            return $this->response->error('Nothing To Show',404);
        }
        return $this->response->json(['message' => 'eventParticipant Fetched Succesfuly','item'=>$eventParticipant,'statusCode'=>200]);
    }

    // create new participants for an event
    public function create(){

        $eventParticipantData = $this->request->all();


        $eventParticipant = new EventParticipant();
        $errors=$eventParticipant->createValidationRule($eventParticipantData);
        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        try{
            $eventParticipant = new EventParticipant();
            //execute query to check if the given participant is already participat to a given event
            $alreadyExsisteventParticipant = $eventParticipant->where('event_id','=',$eventParticipantData->event_id)
                            ->where('participant_id','=',$eventParticipantData->participant_id)->first();
    
        }catch(\Exception $e){
            return $this->response->json(['message' => $e->getMessage(),'statusCode'=>404]);

        }

        //return message if participated
        if(isset($alreadyExsisteventParticipant)){
            return $this->response->json(['message' => 'Already Participated','statusCode'=>404]);

        }
        //prepare the record
        $eventParticipant->setAttributes([
            'event_id'=>$eventParticipantData->event_id,
            'participant_id'=>$eventParticipantData->participant_id,
        ]);
        //execute insert query
        try{
            $eventParticipant->save();
        }
        catch(\Exception $e){
            //to-do : log the exception
            return $this->response->json(['message' => 'faild to create','statusCode'=>404]);

        }

        return $this->response->json(['message' => 'eventParticipants Created Succesfuly','statusCode'=>200]);

    }

    //get all the participants for an event
    public function getParticipants($id){
        $perPage = $this->request->input('perPage',5) ;
        $page =  $this->request->input('page',1);


        $participants = new EventParticipant();
        //valiadtion rule
        $errors=$participants->idValidationRule($id);
        $errors=$participants->listValidationRules($this->request->all());
         //validaiton errors
         if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        // prepare and execute query
        $participants = $participants->where('event_id','=',$id)
                                    ->join('participants as p','participant_id','=','p.id')
                                    ->paginate($perPage,$page);

        if(count($participants['data'] )== 0 ){
            return $this->response->error('Nothing To Show',404);
        }
        return $this->response->json(['message' => 'participants Fetched Succesfuly','item'=>$participants,'statusCode'=>200]);
    }
}