<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionController extends ETController
{
    //http://localhost/esoTalk/transaction cannot be called... hm?
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
    public function action_edit($data)
    {
        //TODO
    }
    public function action_delete($data)
    {
        //TODO
    }
    public function action_add($data)
    {
        //TODO
    }


}