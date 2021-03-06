<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionModel extends ETModel
{
    public function __construct()
    {
        parent::__construct("et_clancash","id");
    }
    public function getLastTen()
    {
        //TODO get the tableprefix
        //selects the last ten entries in the transaction table and returns all rows as multi-arrays
        $res = ET::$database->query("SELECT c.id, m.username, c.transactionDate, c.description, c.value FROM eso_clancash c LEFT JOIN eso_member m ON m.memberId = c.memberId ORDER BY c.transactionDate DESC LIMIT 0,50")->allRows();
        return $res;
    }
    public function getNetSum()
    {
        //selects the net sum of all payments -- all payments!
        $res = ET::$database->query("SELECT TRUNCATE(SUM(value),2) AS netSum FROM eso_clancash")->firstRow();
        return $res;
    }
    public function getSome()
    {
        //TODO i want some pageination stuff be included in the view first.
    }
}
