<?php

declare(strict_types=1);

use App\App\App;
use App\App\Database\QueryBuilder;
use App\App\Database\Connection;

require 'vendor/autoload.php';
require 'helpers/view.php';
require 'helpers/redirect.php';

App::bind('config', require 'config.php');

if (App::get('config')['DEBUG']) {
    require 'helpers/dd.php';
}
// выходжу за рамки требований, потому что... ну кайф же тут поставить это!
if (!empty($_SESSION) && $_SESSION['user']) {
    App::bind('user', \App\Models\User::make($_SESSION['user']));
}

App::bind(
    'DB',
    new QueryBuilder(Connection::make(App::get('config')['DB']))
);
