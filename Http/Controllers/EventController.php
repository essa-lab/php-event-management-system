<?php

namespace Http\Controllers;
use Http\Models\Event;

class EventController extends Controller{

     // list of all the Events
    public function index(){
        $perPage = $this->request->input('perPage',5) ;
        $page =  $this->request->input('page',1);

        $events = new Event();
        // validation rules
        $errors = $events->listValidationRules($this->request->all());
        // Validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }
        // search fucntionality
        if($this->request->has('event_title') && $this->request->input('event_title')){
           $events =  $events->where('title','like','%'.$this->request->input('event_title').'%');
        }
        if($this->request->has('start_date') && $this->request->input('start_date')){
           $events =  $events->where('start_date','=',$this->request->input('start_date'));
        }
        if($this->request->has('end_date') && $this->request->input('end_date')){
           $events =  $events->where('end_date','=',$this->request->input('end_date'));
        }
        if($this->request->has('location_id') && $this->request->input('location_id')){
           $events =  $events->where('location_id','=',$this->request->input('location_id'));
        }

        // add join clause to the query (to get the location name)
        $events= $events->join('locations as l','location_id','=','l.id');
        try{
            //execute the built sql query
            $events = $events->paginate($perPage,$page);

        }catch(\Exception $e){
            // return any error if occure
            return $this->response->error($e->getMessage(),404);

        }

        if(count($events['data'] )== 0 ){
            return $this->response->error('Nothing To Show',404);
        }
        return $this->response->json(['message' => 'Events Fetched Succesfuly','item'=>$events,'statusCode'=>200]);
    }

    // get the data for specific event id
    public function read($id){

        $event = new Event();
        //validation rule
        $errors = $event->idValidationRule($id);
        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }
        // execute the query
        $event  = $event->find($id);
        if(!isset($event)){
            return $this->response->error('Event Not Found',404);
        }
        return $this->response->json(['message' => 'Event Fetched Succesfuly','item'=>$event->get(),'statusCode'=>200]);


    }

    // create new event
    public function create(){
        $eventData = $this->request->all();
       
        $event = new Event();
        // validation rule
        $errors = $event->createValidationRule($eventData);
        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //prepare the event table record
        $event->setAttributes([
            'title'=>$eventData->event_title,
            'location_id'=>$eventData->location_id,
            'start_date'=>$eventData->start_date,
            'end_date'=>$eventData->end_date
        ]);
        //execute the query
        $event->save();

        return $this->response->json(['message' => 'Events Created Succesfuly','statusCode'=>200]);

    }

    // update event record
    public function update($id){
        $eventData = $this->request->all();

        $event = new Event();
        //validation rule
        $errors=$event->updateValidationRule($id,$eventData);
        //validation erros
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //get the event
        $event = $event->find($id);
        // event with the given id not exsist
        if(empty($event)){
            return $this->response->error('Event Not Found',404);
        }
        //prepare the event
        $event->setAttributes([
            'event_id'=>$id,
            'title'=>$eventData->event_title,
            'location_id'=>$eventData->location_id,
            'start_date'=>$eventData->start_date,
            'end_date'=>$eventData->end_date
        ]);
        //execute the query
        $event->save();

        return $this->response->json(['message' => 'Events Updated Succesfuly','statusCode'=>200]);

    }

    
    // delete event
    public function delete($id){
        $event = new Event();
        //validation rule
        $errors = $event->idValidationRule($id);

        //validation error
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //get the event
        $event = $event->find($id);
        
        //delete it 
        if($event->delete()){
            return $this->response->json(['message' => 'Events Deleted Succesfuly','statusCode'=>200]);
        }
        return $this->response->json(['message' => 'Events Not Found','statusCode'=>404]);

    }

    // fucntion to fill a frontend select element
    public function eventForSelect(){
        $events = (new Event())::all();

        return $this->response->json(['message'=>'ok','events'=>$events]);
  
    }
}