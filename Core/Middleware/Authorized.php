<?php

namespace Core\Middleware;
use Core\Session;
use Http\Models\User;

class Authorized
{
    //handle blacklist and whitelist logic (authorized request only can pass)
    public function handle()
    {
        $apiKey = Session::get('api_key');
        if (!Session::get('api_key')) {
            throw new \Exception('Not Authorized');
        }
        $user = new User();
        $user = $user->where('api_key','=',$apiKey)->first();
        //check if there is auser with the giving api_key;
        if(!isset($user)){
            throw new \Exception( 'Not Authorized');
        }        
        //get user attributes
        $user = $user->get();
        //check if the user blocked
        if($user['is_blocked']){
            throw new \Exception('You Are BLOCKED');
        }
    }
}