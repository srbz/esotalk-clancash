<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionAdminReoccuringModel extends ETModel
{
    public function __construct()
    {
        parent::__construct("clancash_reocc","id");
    }
    public function getReoccuringTransactions()
    {
        //TODO get the tableprefix
        //selects the last ten entries in the transaction table and returns all rows as multi-arrays
        $res = ET::$database->query("SELECT c.id, m.username, c.nextTransactionDate, c.description, c.value FROM eso_clancash_reocc c LEFT JOIN eso_member m ON m.memberId = c.memberId ORDER BY c.id DESC LIMIT 0,50")->allRows();
        return $res;
    }
    public function getNetSumPerReocc()
    {
        //selects the net sum of all payments -- all payments!
        $res = ET::$database->query("SELECT TRUNCATE(SUM(value),2) AS reoccSum FROM eso_clancash_reocc")->firstRow();
        return $res;
    }
    public function addTransaction($values)
    {
        /*
        *    values =>
        *        array(
        *            description => string,
        *            value => string,
        *            nextTransactiondate => string
        *            id => DB does it
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
    public function getById($id)
    {
        //TODO change it into the ET::SQL() statement because of user-entry-data ($id)
        $res = ET::$database->query("SELECT c.id, m.username, c.nextTransactionDate, c.description, c.value FROM eso_clancash_reocc c LEFT JOIN eso_member m ON m.memberId = c.memberId WHERE c.id = $id")->firstRow();
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
    public function incMonthOfId($id,$oldDate)
    {
        //well just increase the nextTransactionDate for the reocctransaction with id = $id

        return ET::$database->query("UPDATE eso_clancash_reocc SET nextTransactionDate = DATE_ADD('$oldDate', INTERVAL 1 MONTH) WHERE id = ".$id);
        // return ET::SQL()->update($this->table)
        //     ->set(array("nextTransactionDate" => "date_add('nextTransactionDate', INTERVAL 1 MONTH)"),false,false)
        //     ->where("id = ".$id)
        //     ->exec();
    }
}
