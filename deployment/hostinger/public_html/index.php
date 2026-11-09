<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../restorant-php/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../restorant-php/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../restorant-php/bootstrap/app.php';

// Bind public path to this public_html directory for assets and uploads
if (method_exists($app, 'usePublicPath')) {
    $app->usePublicPath(__DIR__);
}

$app->handleRequest(Request::capture());
