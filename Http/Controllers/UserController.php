<?php

namespace Http\Controllers;
use DateTime;
use Http\Models\User;

class UserController extends Controller{

     // list of all the Users
    public function index(){
        $perPage = $this->request->input('perPage',5) ;
        $page =  $this->request->input('page',1);

        $users = new User();
        // validation rules
        $errors = $users->listValidationRules($this->request->all());
        // Validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }
        // search fucntionality
        if($this->request->has('name') && $this->request->input('name')){
           $users =  $users->where('name','like','%'.$this->request->input('name').'%');
        }
        if($this->request->has('is_blocked') && $this->request->input('is_blocked')){
           $users =  $users->where('is_blocked','=',$this->request->input('is_blocked'));
        }

        try{
            //execute the built sql query
            $users = $users->paginate($perPage,$page);

        }catch(\Exception $e){
            // return any error if occure
            return $this->response->error($e->getMessage(),404);

        }

        if(count($users['data'] )== 0 ){
            return $this->response->error('Nothing To Show',404);
        }
        return $this->response->json(['message' => 'users Fetched Succesfuly','item'=>$users,'statusCode'=>200]);
    }

    // get the data for specific user id
    public function read($id){

        $user = new User();
        //validation rule
        $errors = $user->idValidationRule($id);
        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }
        // execute the query
        $user  = $user->find($id);
        if(!isset($user)){
            return $this->response->error('user Not Found',404);
        }
        return $this->response->json(['message' => 'user Fetched Succesfuly','item'=>$user->get(),'statusCode'=>200]);


    }

    // create new User
    public function create(){
        $userData = $this->request->all();
       
        $user = new User();
        // validation rule
        $errors = $user->createValidationRule($userData);
        //validation errors
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //prepare the user table record
        $user->setAttributes([
            'name'=>$userData->name,
            'ip'=>$userData->ip,
            'is_blocked'=>$userData->is_blocked,
            'api_key'=>uniqid()
        ]);
        //execute the query
        $user->save();

        return $this->response->json(['message' => 'users Created Succesfuly','statusCode'=>200]);

    }

    // update user record
    public function update($id){
        $userData = $this->request->all();

        $user = new user();
        //validation rule
        $errors=$user->updateValidationRule($id,$userData);
        //validation erros
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //get the user
        $user = $user->find($id);
        // user with the given id not exsist
        if(empty($user)){
            return $this->response->error('user Not Found',404);
        }
        //prepare the user
        $date = new DateTime();
        $user->setAttributes([
            'id'=>$id,
            'name'=>$userData->name,
            'is_blocked'=>$user->get()->is_blocked,
            'ip'=>$userData->ip,
            'blocked_at'=>$user->get()->blocked_at
        ]);
        //execute the query
        $user->save();

        return $this->response->json(['message' => 'users Updated Succesfuly','statusCode'=>200]);

    }

    
    // delete user
    public function delete($id){
        $user = new User();
        //validation rule
        $errors = $user->idValidationRule($id);

        //validation error
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //get the user
        $user = $user->find($id);
        
        //delete it 
        if($user->delete()){
            return $this->response->json(['message' => 'users Deleted Succesfuly','statusCode'=>200]);
        }
        return $this->response->json(['message' => 'users Not Found','statusCode'=>404]);

    }

    public function login(){
        $user = new User();
        $loginData = $this->request->all();
        $errors = $user->validateUserNameRule($loginData);
        //validation error
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //get the user
        $user = $user->where('name','=',$loginData->username)->first();
        
        // user with the given id not exsist
        if(empty($user)){
            return $this->response->error('invalid username',404);
        }

        return $this->response->json(['message' => 'user logged in successfully','apiKey'=>$user->get()['api_key'],'statusCode'=>200]);

    }

    public function toggleBlock($id){
        $user = new User();
        //validation rule
        $errors = $user->idValidationRule($id);

        //validation error
        if(!empty($errors)){
            return $this->response->json(['message'=>'Validation Errors','errors'=>$errors],403);
        }

        //get the user
        $user = $user->find($id);
        
        // user with the given id not exsist
        if(empty($user)){
            return $this->response->error('user Not Found',404);
        }

        $userData=$user->get();
        $date = new DateTime();
        $user->setAttributes([
            'id'=>$id,
            'is_blocked'=>$userData['is_blocked']==0?1:0,
            'ip'=>$userData['ip'],
            'name'=>$userData['name'],
            'api_key'=>$userData['api_key'],
            'blocked_at'=>$userData['is_blocked']==0?$date->format('Y-m-d H:i:s'):null
        ]);
        $user->save();

        return $this->response->json(['message' => 'Block Toggled Succesfuly','statusCode'=>200]);

    }

}