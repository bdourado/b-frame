<?php

declare(strict_types=1);

/**
 * Application Routes
 * (Routes can also be defined via Attributes in Controllers)
 */

use BFrame\Core\Router;

// Main Application Routes
Router::get('/', 'HomeController@index');
Router::get('/features', 'FeaturesController@index');

// API Routes
Router::get('/api/test', 'Api\TestController@index');
Router::post('/api/test', 'Api\TestController@create');