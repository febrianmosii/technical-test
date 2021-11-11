<?php
/*
*  ---------------------------
*  Load Controller
*  ---------------------------
*/

require(PATH_CONTROLLER . 'TransactionsController.php');

/*
*  ---------------------------
*  Load All Model
*  ---------------------------
*/
require('app/__model.php');

/*
* -------------------
*     ROUTES
* -------------------
*/
$accessedPath = $_SERVER['PATH_INFO'];

switch ($accessedPath) {
    case '/api/v1/transaction':
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            TransactionsController::listTransactions();
        } else if ($method === 'POST') {
            TransactionsController::createTransaction();
        } else {
            RestHelper::set_response(403, "Method not allowed");
        }

        break;
    
    default:
        RestHelper::set_response(404, "Sorry URL you entered is not found");
        break;
}