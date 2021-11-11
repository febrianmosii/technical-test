<?php

define('PATH_CONFIG', 'app/config/');
define('PATH_CONTROLLER', 'app/controller/');
define('PATH_MODEL', 'app/model/');
define('PATH_HELPER', 'app/helpers/');
// define('PATH_VIEW', 'resources/view/');
// define('PATH_PUBLIC', 'public/');
define('PATH_VENDOR', 'vendor/');

// Include autoload file
require(PATH_VENDOR . 'autoload.php');

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

/*
*  ---------------------------
*  Load All Helpers
*  ---------------------------
*/
require('app/__helpers.php');

$messageNotAllowed = '';

// Validate API KEY
if (empty($_SERVER['HTTP_X_API_KEY'])) {
    RestHelper::set_response(403, $messageNotAllowed);
}

if ($_SERVER['HTTP_X_API_KEY'] != getenv('X_API_KEY')) {
    RestHelper::set_response(403, $messageNotAllowed);
}

/** Start Controller **/
require('app/routes.php');
