<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

function root_dir()
{
    return realpath(__DIR__ . '/..');
}

require root_dir() . '/vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require root_dir() . '/src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require root_dir() . '/src/dependencies.php';

// Register middleware
require root_dir() . '/src/middleware.php';

// Register routes
require root_dir() . '/src/routes.php';

// Run app
$app->run();
