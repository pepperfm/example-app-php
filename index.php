<?php

declare(strict_types=1);

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require 'app/bootstrap.php';

use App\App\Router;
use App\App\Request;
try {
    Router::load('routes.php')->direct(Request::uri(), Request::method());
} catch (Exception $e) {
}
