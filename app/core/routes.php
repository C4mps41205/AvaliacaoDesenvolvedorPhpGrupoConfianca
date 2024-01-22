<?php

$routes = 
[
    '/' => 'IndexController@index',
    '/index/select' => 'IndexController@selectClient',
    '/index/delete/{id}' => 'IndexController@delete',
    '/index/update' => 'IndexController@update',
    '/index/create' => 'IndexController@create',
];
