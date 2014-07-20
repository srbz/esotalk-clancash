<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionAdminController extends ETAdminController
{
    //http://localhost/esoTalk/admin/transactionAdmin cannot be called... hm?
    public function action_index()
    {
        if (!$this->allowed()) return;
        $transModel = ETFactory::make("transactionAdminModel");
        $reoccModel = ETFactory::make("transactionAdminReoccuringModel");
        $results = $transModel->getLastTen();
        $reocc = $reoccModel->getReoccuringTransactions();
        $sum = $transModel->getNetSum();
        $reoccSum = $reoccModel->getNetSumPerReocc();
        $this->data("netSum",$sum);
        $this->data("trans",$results);
        $this->data("reocc",$reocc);
        $this->data("reoccSum", $reoccSum);
        $this->render("admin/TransactionAdminIndexView");
    }
    public function action_edit($id)
    {

    }
    public function action_delete($id)
    {

    }
    public function action_add($data)
    {

    }
    public function action_addReocc($data)
    {

    }
    public function action_delReocc($data)
    {

    }
    public function action_editReocc($data)
    {

    }
    public function checkReoccuring()
    {

    }

}
