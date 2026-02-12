<?php

declare(strict_types=1);

/**
 * Application Routes
 * * You can define routes manually here or use PHP 8.4 Attributes 
 * directly in your Controller methods.
 */

use BFrame\Core\Router;

// --- Web Routes ---

/**
 * Home Route
 * Map the root URL to the index method of HomeController
 */
Router::get('/', 'HomeController@index');

/**
 * Features Route
 * Displays framework features and documentation
 */
Router::get('/features', 'FeaturesController@index');


// --- API Routes ---

/**
 * API Test Group
 * Example of handling different HTTP verbs for the same endpoint
 */
Router::get('/api/test', 'Api\TestController@index');
Router::post('/api/test', 'Api\TestController@create');


// --- System Routes ---

/**
 * Fallback Route (Optional)
 * You can define a custom 404 handler here if your Router supports it
 */
// Router::any('/404', 'ErrorController@notFound');