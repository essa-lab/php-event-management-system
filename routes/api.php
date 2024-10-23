<?php

$router->get('/api', 'ApiController@index')->only('auth');

$router->get('/api/event', 'EventController@index');
$router->post('/api/event', 'EventController@create')->only('authorized');
$router->get('/api/event/{id}', 'EventController@read');
$router->put('/api/event/{id}', 'EventController@update')->only('authorized');
$router->delete('/api/event/{id}', 'EventController@delete')->only('authorized');

$router->get('/api/location', 'LocationController@index');
$router->post('/api/location', 'LocationController@create')->only('authorized');
$router->get('/api/location/{id}', 'LocationController@read');
$router->put('/api/location/{id}', 'LocationController@update')->only('authorized');
$router->delete('/api/location/{id}', 'LocationController@delete')->only('authorized');


$router->get('/api/participant', 'ParticipantController@index');
$router->post('/api/participant', 'ParticipantController@create')->only('authorized');
$router->get('/api/participant/{id}', 'ParticipantController@read');
$router->put('/api/participant/{id}', 'ParticipantController@update')->only('authorized');
$router->delete('/api/participant/{id}', 'ParticipantController@delete')->only('authorized');

$router->get('/api/event-participant', 'EventParticipantController@index');
$router->post('/api/event-participant', 'EventParticipantController@create')->only('authorized');
$router->get('/api/event-participant/{id}', 'EventParticipantController@read');
$router->put('/api/event-participant/{id}', 'EventParticipantController@update')->only('authorized');
$router->delete('/api/event-participant/{id}', 'EventParticipantController@delete')->only('authorized');

$router->get('/api/show-participant/{id}', 'EventParticipantController@getParticipants');



$router->get('/api/location-options', 'LocationController@locationsForSelect');
$router->get('/api/participant-options', 'ParticipantController@participantForSelect');
$router->get('/api/event-options', 'EventController@eventForSelect');

$router->get('/api/user', controller: 'UserController@index');
$router->post('/api/user', 'UserController@create')->only('authorized');
$router->get('/api/user/{id}', 'UserController@read')->only('authorized');
$router->put('/api/user/{id}', 'UserController@update')->only('authorized');
$router->delete('/api/user/{id}', 'UserController@delete')->only('authorized');
$router->put('/api/toggle-block/{id}', 'UserController@toggleBlock')->only('authorized');
$router->post('/api/login', 'UserController@login');



