<?php
/**
 * Application Routes
 */

use BFrame\Core\Router;

Router::get('/', 'HomeController@index');

// API Routes
Router::get('/api/test', 'Api\TestController@index');
Router::post('/api/test', 'Api\TestController@create');

// Example of dynamic route
// Router::get('/user/{id}', 'UserController@show');