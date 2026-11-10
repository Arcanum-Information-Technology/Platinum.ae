<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto-detect the Laravel application directory
// Supports Platinum.ae, plantinumclub, or any sibling project directory
$appCandidates = [
    __DIR__ . '/../Platinum.ae',
    __DIR__ . '/../plantinumclub',
    __DIR__ . '/..',
];

$appPath = null;
foreach ($appCandidates as $candidate) {
    if (file_exists($candidate . '/bootstrap/app.php') && file_exists($candidate . '/vendor/autoload.php')) {
        $appPath = realpath($candidate);
        break;
    }
}

// Fallback: search any sibling directory that contains bootstrap/app.php
if (!$appPath) {
    $parent = realpath(__DIR__ . '/..');
    if ($parent && is_dir($parent)) {
        foreach (scandir($parent) as $entry) {
            if ($entry !== '.' && $entry !== '..' && $entry !== 'public_html') {
                $dir = $parent . DIRECTORY_SEPARATOR . $entry;
                if (is_dir($dir) && file_exists($dir . '/bootstrap/app.php') && file_exists($dir . '/vendor/autoload.php')) {
                    $appPath = $dir;
                    break;
                }
            }
        }
    }
}

if (!$appPath) {
    http_response_code(500);
    die("<h1>Deployment Error</h1><p>Could not locate the Laravel application directory. Please ensure the project directory exists alongside public_html.</p>");
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $appPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $appPath . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $appPath . '/bootstrap/app.php';

// Bind public path to this public_html directory for assets and uploads
if (method_exists($app, 'usePublicPath')) {
    $app->usePublicPath(__DIR__);
}

$app->handleRequest(Request::capture());
