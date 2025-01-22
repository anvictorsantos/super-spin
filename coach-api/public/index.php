<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Controllers\CoachController;
use Gateways\CoachGateway;
use Database\Database;
use Utilities\ErrorHandler;
use Phroute\Phroute\RouteCollector;

spl_autoload_register(function (string $class) {
    $file = __DIR__ . '/../src/' . str_replace("\\", "/", $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

set_error_handler([ErrorHandler::class, "handleError"]);
set_exception_handler([ErrorHandler::class, "handleException"]);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$database = new Database();
$gateway = new CoachGateway($database);
$controller = new CoachController($gateway);

$router = new RouteCollector();

// Define routes
$router->group(['prefix' => '/coaches'], function (RouteCollector $router) use ($controller) {
    $router->get('/', [$controller, 'getAllCoaches']); // Collection route
    $router->post('/', [$controller, 'createCoach']); // Create new coach
    $router->get('/{id}', [$controller, 'getCoach']); // Get a single coach
    $router->patch('/{id}', [$controller, 'updateCoach']); // Update a single coach
    $router->delete('/{id}', [$controller, 'deleteCoach']); // Delete a single coach
});

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    echo $response;
} catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    http_response_code(404);
    echo json_encode(['message' => 'Route not found']);
} catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}
