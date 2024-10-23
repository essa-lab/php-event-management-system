<?php

namespace Http\Controllers;
use Http\Models\Location;

class LocationController extends Controller{

    //list of all the locaitons
    public function index(){
        
        $perPage = $this->request->input('perPage',5) ;
        $page =  $this->request->input('page',1);
        $locations = new Location();

        //validation rules
        $errors=$locations->listValidationRules($this->request->all());

        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }
        

        //search funcationality
        if($this->request->has('location_name') && $this->request->input('location_name')){
           $locations =  $locations->where('location_name','like','%'.$this->request->input('location_name').'%');
        }
        if($this->request->has('address') && $this->request->input('address')){
           $locations =  $locations->where('address','like','%'.$this->request->input('address').'%');
        }
        if($this->request->has('capacity') && $this->request->input('capacity')){
           $locations =  $locations->where('capacity','>=',$this->request->input('capacity'));
        }

        //execute the query
        $locations = $locations->paginate($perPage,$page);
        if(count($locations['data'] )== 0 ){
            return $this->response->error('Nothing To Show',404);
        }
        return $this->response->json(['message' => 'locations Fetched Succesfuly','item'=>$locations,'statusCode'=>200]);
    }

    // get the data for specific locaiton id
    public function read($id){

        //validation rules
        $location = new Location();
        $errors = $location->idValidationRule($id);
        //validation errirs
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //prepare and execute the query
        $location = $location->find($id);
        if(!isset($location)){
            return $this->response->error('Location Not Found',404);

        }
        return $this->response->json(['message' => 'location Fetched Succesfuly','item'=>$location->get(),'statusCode'=>200]);


    }

    // create new location
    public function create(){
        $locationDate = $this->request->all();
        $location = new Location();
        //validationrule
        $errors=$location->createValidationRule($locationDate);      

        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //prepare quest
        $location->setAttributes([
            'location_name'=>$locationDate->location_name,
            'address'=>$locationDate->address,
            'capacity'=>$locationDate->capacity,
        ]);
        //execute query
        $location->save();

        return $this->response->json(['message' => 'Location Created Succesfuly','statusCode'=>200]);

    }

    // update location record
    public function update($id){
        $locationData = $this->request->all();
        //validation rules
        $location=new Location();
        $errors=$location->updateValidationRule($id,$locationData);
        //valiaditon errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //check if the given id for an location exsist
        $location = $location->find($id);
        if(empty($location)){
            return $this->response->error('location Not Found',404);
        }
        //prepare query
        $location->setAttributes([
            'id'=>$id,
            'location_name'=>$locationData->location_name,
            'address'=>$locationData->address,
            'capacity'=>$locationData->capacity,
        ]);
        //execute query
        $location->save();

        return $this->response->json(['message' => 'Location Updated Succesfuly','statusCode'=>200]);

    }

    // delete locaiton
    public function delete($id){
        $location =new Location();
        //validation rule
        $errors = $location->idValidationRule($id);
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //prepare and execute query
        $location = $location->find($id);
        //if not found return error
        if(empty($location)){
            return $this->response->error('location Not Found',404);
        }
        //delet query execuation
        if($location->delete()){
            return $this->response->json(['message' => 'Location Deleted Succesfuly','statusCode'=>200]);
        }
        return $this->response->json(['message' => 'Location Not Found','statusCode'=>404]);

    }

    // function to fill a frontend select element
    public function locationsForSelect(){
        $locations = (new Location())::all();

        return $this->response->json(['message'=>'ok','locations'=>$locations]);
  

    }
}

