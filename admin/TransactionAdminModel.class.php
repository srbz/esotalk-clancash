<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionAdminModel extends ETModel
{
    public function __construct()
    {
        parent::__construct("et_clancash","id");
    }
    public function getLastTen()
    {
        //TODO get the tableprefix
        //selects the last ten entries in the transaction table and returns all rows as multi-arrays
        $res = ET::$database->query("SELECT c.id, m.username, c.transactionDate, c.description, c.value FROM et_clancash c LEFT JOIN et_member m ON m.memberId = c.memberId ORDER BY c.id DESC LIMIT 0,50")->allRows();
        return $res;
    }
    public function getNetSum()
    {
        //selects the net sum of all payments -- all payments!
        $res = ET::$database->query("SELECT TRUNCATE(SUM(value),2) AS netSum FROM et_clancash")->firstRow();
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
