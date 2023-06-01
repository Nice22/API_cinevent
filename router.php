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
        'GET' => ['MoviesController', 'getAllMovies'],
        'POST' => ['MoviesController', 'addMovie']
    ],
    '/movies/{id}' => [
        'GET' => ['MoviesController', 'getMovieById'],
        'PUT' => ['MoviesController', 'updateMovie'],
        'DELETE' => ['MoviesController', 'deleteMovie']
    ],
    '/payments' => [
        'GET' => ['PaymentsController', 'getAllPayments'],
        'POST' => ['PaymentsController', 'addPayment']
    ],
    '/payments/{id}' => [
        'GET' => ['PaymentsController', 'getPaymentById'],
        'PUT' => ['PaymentsController', 'updatePayment'],
        'DELETE' => ['PaymentsController', 'deletePayment']
    ],
    '/sessions' => [
        'GET' => ['SessionsController', 'getAllSessions'],
        'POST' => ['SessionsController', 'addSession']
    ],
    '/sessions/{id}' => [
        'GET' => ['SessionsController', 'getSessionById'],
        'PUT' => ['SessionsController', 'updateSession'],
        'DELETE' => ['SessionsController', 'deleteSession']
    ],
    '/trailers' => [
        'GET' => ['TrailersController', 'getAllTrailers'],
        'POST' => ['TrailersController', 'addTrailer']
    ],
    '/trailers/{id}' => [
        'GET' => ['TrailersController', 'getTrailerById'],
        'PUT' => ['TrailersController', 'updateTrailer'],
        'DELETE' => ['TrailersController', 'deleteTrailer']
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
            $controllerName = $method[0];
            $methodName = $method[1];
            $args = array_slice($matches, 1);

            // Call the corresponding controller method
            $controller = new $controllerName();
            call_user_func_array([$controller, $methodName], $args);
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
