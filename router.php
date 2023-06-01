<?php

require_once('controllers/MoviesController.php');
require_once('controllers/PaymentsController.php');
require_once('controllers/SessionsController.php');
require_once('controllers/TrailersController.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string from the request URI
$requestUri = strtok($requestUri, '?');

// Remove trailing slash from the request URI
$requestUri = rtrim($requestUri, '/');

// Define the base URL
$baseUrl = '/api';

// Remove the base URL from the request URI
$requestPath = substr($requestUri, strlen($baseUrl));

// Define the routes
$routes = [
    '/movies' => [
        'GET' => 'getAllMovies',
        'POST' => 'addMovie'
    ],
    '/movies/{id}' => [
        'GET' => 'getMovieById',
        'PUT' => 'updateMovie',
        'DELETE' => 'deleteMovie'
    ],
    '/payments' => [
        'GET' => 'getAllPayments',
        'POST' => 'addPayment'
    ],
    '/payments/{id}' => [
        'GET' => 'getPaymentById',
        'PUT' => 'updatePayment',
        'DELETE' => 'deletePayment'
    ],
    '/sessions' => [
        'GET' => 'getAllSessions',
        'POST' => 'addSession'
    ],
    '/sessions/{id}' => [
        'GET' => 'getSessionById',
        'PUT' => 'updateSession',
        'DELETE' => 'deleteSession'
    ],
    '/trailers' => [
        'GET' => 'getAllTrailers',
        'POST' => 'addTrailer'
    ],
    '/trailers/{id}' => [
        'GET' => 'getTrailerById',
        'PUT' => 'updateTrailer',
        'DELETE' => 'deleteTrailer'
    ],
];

// Find a matching route
$routeFound = false;
foreach ($routes as $route => $methods) {
    $pattern = '#^' . preg_replace('/{.+?}/', '([^/]+)', $route) . '$#';
    if (preg_match($pattern, $requestPath, $matches)) {
        if (isset($methods[$requestMethod])) {
            $routeFound = true;
            $method = $methods[$requestMethod];
            $args = array_slice($matches, 1);

            // Call the corresponding controller method
            call_user_func_array($method, $args);
            break;
        }
    }
}

// If no matching route found, return 404 Not Found
if (!$routeFound) {
    http_response_code(404);
    echo '404 Not Found';
}

?>
