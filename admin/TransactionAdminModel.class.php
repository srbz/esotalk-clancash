<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionAdminModel extends ETModel
{
    public function __construct()
    {
        parent::__construct("clancash","id");
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
    public function addTransaction($values)
    {
        /*
        *    values =>
        *        array(
        *            description => string,
        *            value => string,
        *            date => controller does it
        *            id => controller does it
        *        )
        */
        //INSERT $VALUES INTO $THIS->TABLE
        return ET::SQL()->insert($this->table)
                ->set($values)
                ->exec();
    }
    public function editTransaction($id,$values)
    {
        /*
        *    values =>
        *        array(
        *            description => string,
        *            value => string
        *        )
        */
        //UPDATE $VALUES FROM $THIS->TABLE WHERE ID=$ID
        return ET::SQL()->update($this->table)
                ->set($values)
                ->where("id = ".$id)
                ->exec();
    }
    //I have rewritten this method by the purpose of my needs! -- Cause of fancy normalization
    public function getById($id)
    {
        //TODO change it into the ET::SQL() statement because of user-entry-data ($id)
        $res = ET::$database->query("SELECT c.id, m.username, c.nextTransactionDate, c.description, c.value FROM eso_clancash c LEFT JOIN eso_member m ON m.memberId = c.memberId WHERE c.id = $id")->firstRow();
        return $res;
    }
    public function cleanFormData($formData)
    {
        //the array which form gives back is dirty... we have to clear it first
        unset($formData['token']);
        unset($formData['save']);
        unset($formData['cancel']);
        //return the not so dirty array
        return $formData;
    }
    public function getIdForUsername($username)
    {
        //returns the memberID for a given username
        return ET::SQL()->select("memberId")->from("member")->where("username = '".$username."'")->exec()->firstRow();
    }
}
