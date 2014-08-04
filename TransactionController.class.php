<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionController extends ETController
{
    // transaction/index actionhandler
    public function action_index()
    {
        if (!$this->allowed()) return;

        $model = ETFactory::make("transactionModel");
        $results = $model->getLastTen();
        $sum = $model->getNetSum();
        $this->data("netSum",$sum);
        $this->data("trans",$results);
        $this->render("TransactionIndexView");

    }
    //there is nothing more a simple user could do at the moment
}
