<?php

namespace Http\Controllers;

class WebController{

    public function home(){
        view("home.view.php", [
            'title' => 'Home',
            'subTitle'=>'Introduction'
        ]);
    }
    public function eventList(){
        view("event/event.view.php", [
            'title' => 'Events',
            'subTitle'=>'Event Table'
        ]);
    }

    public function eventForm($id){
        view("event/event-form.view.php", [
            'title' => 'Event Form',
            'id'=>$id
        ]);
    }

    public function locationList(){
        view("location/location.view.php", [
            'title' => 'Locations',
            'subTitle'=>'Locations Table'
        ]);
    }

    public function locationForm($id){
        view("location/location-form.view.php", [
            'title' => 'Location Form',
            'id'=>$id
        ]);
    }

    public function participantList(){
        view("participant/participant.view.php", [
            'title' => 'Participants',
            'subTitle'=>'Participants Table'
        ]);
    }

    public function participantForm($id){
        view("participant/participant-form.view.php", [
            'title' => 'Participant Form',
            'id'=>$id
        ]);
    }

    public function eventParticipantList(){
        view("event-participant/event-participant.view.php", [
            'title' => 'Event Participants',
            'subTitle'=>'Event Participants Table'
        ]);
    }

    public function eventParticipantForm($id){
        view("event-participant/event-participant-form.view.php", [
            'title' => 'Event Participant Form',
            'id'=>$id
        ]);
    }

    public function showParticipantList(){
        view("event-participant/show-participant.view.php", [
            'title' => 'Event Participants List',
            'subTitle'=>'Event Participants Table'
        ]);
    }

    public function userList(){
        view("user/user.view.php", [
            'title' => 'users',
            'subTitle'=>'users Table'
        ]);
    }

    public function userForm($id){
        view("user/user-form.view.php", [
            'title' => 'user Form',
            'id'=>$id
        ]);
    }

    public function login(){
        view("user/login.view.php");
    }

}