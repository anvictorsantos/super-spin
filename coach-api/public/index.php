<?php

require __DIR__ . '/../vendor/autoload.php';

use Controllers\CoachController;
use Gateways\CoachGateway;
use Database\Database;
use Utilities\ErrorHandler;

spl_autoload_register(function (string $class) {
    $file = __DIR__ . '/../src/' . str_replace("\\", "/", $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

set_error_handler([ErrorHandler::class, "handleError"]);
set_exception_handler([ErrorHandler::class, "handleException"]);

header("Content-Type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if ($parts[1] != "coaches") {
    http_response_code(404);
    exit;
}

$id = $parts[2] ?? null;

$database = new Database();

$gateway = new CoachGateway($database);

$controller = new CoachController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
