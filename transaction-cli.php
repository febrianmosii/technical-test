<?php 
define('PATH_CONFIG', 'app/config/');
define('PATH_CONTROLLER', 'app/controller/');
define('PATH_MODEL', 'app/model/');
define('PATH_HELPER', 'app/helpers/');
// define('PATH_VIEW', 'resources/view/');
// define('PATH_PUBLIC', 'public/');
define('PATH_VENDOR', 'vendor/');


/*
*  ---------------------------
*  Load Vendor
*  ---------------------------
*/
require(PATH_VENDOR . 'autoload.php');

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

/*
*  ---------------------------
*  Load Transaction Controller
*  ---------------------------
*/

require('app/controller/TransactionsController.php');

/*
*  ---------------------------
*  Load All Model
*  ---------------------------
*/
require('app/__model.php');

/*
*  ---------------------------
*  Load All Helpers
*  ---------------------------
*/
require('app/__helpers.php');

TransactionsController::updateTransaction($argv);