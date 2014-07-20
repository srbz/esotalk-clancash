<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionAdminController extends ETController
{
    //http://localhost/esoTalk/transaction cannot be called... hm?
    public function action_index()
    {
        if (!$this->allowed()) return;
        $model = ETFactory::make("transactionAdminModel");
        $results = $model->getLastTen();
        $sum = $model->getNetSum();
        $this->data("netSum",$sum);
        $this->data("trans",$results);
        $this->render("TransactionAdminIndexView");
    }
    public function action_edit($data)
    {

    }
    public function action_delete($data)
    {

    }
    public function action_add($data)
    {

    }


}
