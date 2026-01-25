<?php
/**
 * Application Routes
 */

use BFrame\Core\Router;

Router::get('/', 'HomeController@index');

// Example of dynamic route
// Router::get('/user/{id}', 'UserController@show');