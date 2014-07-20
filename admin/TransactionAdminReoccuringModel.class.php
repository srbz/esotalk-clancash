<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionAdminReoccuringModel extends ETModel
{
    public function __construct()
    {
        parent::__construct("et_clancash_reocc","id");
    }
    public function getReoccuringTransactions()
    {
        //TODO get the tableprefix
        //selects the last ten entries in the transaction table and returns all rows as multi-arrays
        $res = ET::$database->query("SELECT c.id, m.username, c.nextTransactionDate, c.description, c.value FROM et_clancash_reocc c LEFT JOIN et_member m ON m.memberId = c.memberId ORDER BY c.id DESC LIMIT 0,50")->allRows();
        return $res;
    }
    public function getNetSumPerReocc()
    {
        //selects the net sum of all payments -- all payments!
        $res = ET::$database->query("SELECT TRUNCATE(SUM(value),2) AS reoccSum FROM et_clancash_reocc")->firstRow();
        return $res;
    }
    public function setData($values)
    {
        /*
        *    TODO? not sure if i need to implement this method at the moment
        *    id - int
        *    memberId - int
        *    transactionDate - date
        *    description - string
        *    value - double
        */
    }
}
