<?php

class MainController
{
    public static function index()
    {
        $result = TransactionsController::index();

        return var_dump($result);
    }
}
