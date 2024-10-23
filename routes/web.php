<?php
$router->get('/', 'WebController@home');

$router->get('/event', controller: 'WebController@eventList');
$router->get('/event/{id}', controller: 'WebController@eventForm');

$router->get('/location', 'WebController@locationList');
$router->get('/location/{id}', controller: 'WebController@locationForm');

$router->get('/participant', 'WebController@participantList');
$router->get('/participant/{id}', controller: 'WebController@participantForm');

$router->get('/event-participant', 'WebController@eventParticipantList');
$router->get('/event-participant/{id}', controller: 'WebController@eventParticipantForm');
$router->get('/show-participant/{id}', controller: 'WebController@showParticipantList');

$router->get('/user', 'WebController@userList');
$router->get('/user/{id}', controller: 'WebController@userForm');
$router->get('/login', controller: 'WebController@login');


