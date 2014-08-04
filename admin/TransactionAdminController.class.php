<?php

if(!defined("IN_ESOTALK")) exit;

class TransactionAdminController extends ETAdminController
{
    public function action_index()
    {
        //we need more permissions for this
        if (!$this->allowed()) return;
        $transModel = ETFactory::make("transactionAdminModel");
        $reoccModel = ETFactory::make("transactionAdminReoccuringModel");
        //gets the last 10 entries to show -- TODO extend it with something better
        //TODO maybe all transactions? -- sometimes important
        $results = $transModel->getLastTen();
        //also return all the reoccuring transactions
        $reocc = $reoccModel->getReoccuringTransactions();
        //get the sum of all transactions
        $sum = $transModel->getNetSum();
        //possible reoccuring sum if exectued monthly
        $reoccSum = $reoccModel->getNetSumPerReocc();
        //hand over all the data to the view and rendet it
        $this->data("netSum",$sum);
        $this->data("trans",$results);
        $this->data("reocc",$reocc);
        $this->data("reoccSum", $reoccSum);
        $this->render("admin/TransactionAdminIndexView");
    }
    public function action_edit($id = false)
    {
        //permissions are needed
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $transModel = ETFactory::make("transactionAdminModel");
        //build the form
        $form->action = URL("admin/transaction/save/".$id);
        //seems like i need this
        $form->setValue("id" , $id);
        //get the row with the given id
        $entry = $transModel->getById($id);
        if($entry != null)
        {
            //set the values to the stuff in entry
            $form->setValues($entry);
            //hand over the form to the view
            $this->data("form", $form);
            //and the entry data, because we never know
            $this->data("entry", $entry);
            $this->render("admin/TransactionAdminEditView");
        }
        else{
            redirect(URL("admin/transaction"));
        }
    }
    public function action_save($id = false)
    {
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $transModel = ETFactory::make("transactionAdminModel");
        //if we want to add a new entry
        //TODO use the pattern of esoTalk and use models for this -- not necessery at the moment
        if($id == false){
            $formData = $form->getValues();
            //somehow we have to ensure that the value at least is a number between -infty to +infty as double
            $formData = $transModel->cleanFormData($formData);
            //memberId is the SQL field for the table in DB
            $formData['memberId'] = $transModel->getIdForUsername($formData['username']);
            //unset it because addTransaction doesnt like it
            unset($formData['username']);
            //use currentDate as the transaction date! -- if you want an other date use the edit form! (not yet ready)
            $formData['transactionDate'] = date('Y-m-d');
            if($res = $transModel->addTransaction($formData))
            {
                redirect(URL("admin/transaction"));
            }
            redirect(URL("admin/transaction"));
        }
        else
        {
            if($form->validPostBack("save"))
            {
                //seems like someone wants to save an edit ... fine.
                $formData = $form->getValues();
                //somehow we have to ensure that the value at least is a number between -infty to +infty as double
                $newData = $transModel->cleanFormData($formData);
                //then you can update it...
                if($res = $transModel->editTransaction($id,$newData))
                {
                    //TODO we need a fancy success message!
                    redirect(URL("admin/transaction"));
                    //this->render("admin/TransactionAdminEditView");
                }
                redirect("admin/transaction");
            }
            if($form->validPostBack("cancel"))
            {
                //get him back
                redirect(URL("admin/transaction"));
            }
            else{
                //not sure if this is really needed, but i have the feeling it is.
                redirect(URL("admin/transaction"));
            }
        }
    }
    public function action_delete($id)
    {
        //TODO you better ask the user if he really really want to delete it.
        //enough permission?
        if (!$this->allowed()) return;
        $transModel = ETFactory::make("transactionAdminModel");
        //delete it... without asking
        $transModel->deleteById($id);
        //back to administration -- maybe there is more to delete hue
        redirect(URL("admin/transaction"));
    }
    public function action_add()
    {
        //we need those permissions...
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $transModel = ETFactory::make("transactionAdminModel");
        //call save without an id to generate a new set for the DB
        $form->action = URL("admin/transaction/save/");
        //render it
        $this->data("form", $form);
        $this->render("admin/TransactionAdminAddView");
    }
    public function action_addReocc()
    {
        //we need permissions again
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $reoccModel = ETFactory::make("transactionAdminReoccuringModel");
        //the action will be to add a new reoccuring payment into the table
        $form->action = URL("admin/transaction/saveReocc");
        $this->data("form", $form);
        //this view has a darn long name...
        $this->render("admin/TransactionAdminReoccuringAddView");
    }
    public function action_delReocc($id)
    {
        //TODO you better ask the user if he really really want to delete it.
        //enough permission?
        if (!$this->allowed()) return;
        $reoccModel = ETFactory::make("transactionAdminReoccuringModel");
        //delete it... without asking
        $reoccModel->deleteById($id);
        //back to administration -- maybe there is more to delete hue
        redirect(URL("admin/transaction"));
    }
    public function action_editReocc($id)
    {
        //hue hue you'll never guess where this method is copied from...
        //permissions are needed
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $reoccModel = ETFactory::make("transactionAdminReoccuringModel");
        //build the form
        $form->action = URL("admin/transaction/saveReocc/".$id);
        //seems like i need this
        $form->setValue("id" , $id);
        //get the row with the given id
        $entry = $reoccModel->getById($id);
        if($entry != null)
        {
            //set the values to the stuff in entry
            $form->setValues($entry);
            //hand over the form to the view
            $this->data("form", $form);
            //and the entry data, because we never know
            $this->data("entry", $entry);
            $this->render("admin/TransactionAdminReoccuringEditView");
        }
        else{
            redirect(URL("admin/transaction"));
        }
    }
    public function action_execReocc($id = false)
    {
        //permissions? what are permissions? also ID cannot be false
        if (!$this->allowed() or $id == false) return;
        $form = ETFactory::make("form");
        $reoccModel = ETFactory::make("transactionAdminReoccuringModel");
        $transModel = ETFactory::make("transactionAdminModel");
        //get the values we wanted to execute -- as pseudo automated payment
        $reoccData = $reoccModel->getById($id);
        //if there are no values for that id someone is doin wrong and should be punished for trying this
        if (!($reoccData)) return;
        //use currentDate as the transaction date! -- if you want an other date use the edit form! (not yet ready)
        $reoccData['transactionDate'] = date('Y-m-d');
        $reoccData['memberId'] = $reoccModel->getIdForUsername($reoccData['username']);
        $oldDate = $reoccData['nextTransactionDate'];
        unset($reoccData['nextTransactionDate']);
        unset($reoccData['username']);
        unset($reoccData['id']);
        //set the next month as next date in database ;)
        if($successedInc = $reoccModel->incMonthOfId($id,$oldDate))
        {
            //now you can do the other transaction
            if($successedTrans = $transModel->addTransaction($reoccData))
            {
                //great job!
                //redirection
                //TODO fancy success as always is needed
                redirect(URL("admin/transaction"));
            }
            //shouldnt happen at all but well you never know
            redirect(URL("admin/transaction"));
        }
        //also should never really happen
        redirect(URL("admin/transaction"));
    }
    public function action_saveReocc($id)
    {
        //I copied this from my own save method ... hue hue hue so mean
        //I learned this from my instructor...
        //yea well ask for permissons
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $reoccModel = ETFactory::make("transactionAdminReoccuringModel");
        //if we want to add a new entry
        //TODO use the pattern of esoTalk and use models for this -- not necessery at the moment
        if($id == false){
            $formData = $form->getValues();
            //somehow we have to ensure that the value at least is a number between -infty to +infty as double
            $formData = $reoccModel->cleanFormData($formData);
            //memberId is the SQL field for the table in DB
            $formData['memberId'] = $reoccModel->getIdForUsername($formData['username']);
            //unset it because addTransaction doesnt like it
            unset($formData['username']);
            if($res = $reoccModel->addTransaction($formData))
            {
                redirect(URL("admin/transaction"));
            }
            redirect(URL("admin/transaction"));
        }
        else
        {
            if($form->validPostBack("save"))
            {
                //seems like someone wants to save an edit ... fine.
                $formData = $form->getValues();
                //somehow we have to ensure that the value at least is a number between -infty to +infty as double
                $newData = $reoccModel->cleanFormData($formData);
                //then you can update it...
                var_dump($newData);
                if($res = $reoccModel->editTransaction($id,$newData))
                {
                    var_dump($res);
                    //TODO we need a fancy success message!
                    redirect(URL("admin/transaction"));
                }
                //var_dump($res);
                //echo "save";
                redirect("admin/transaction");
            }
            if($form->validPostBack("cancel"))
            {
                //get him back
                echo "cancel";
                redirect(URL("admin/transaction"));
            }
            else{
                //echo "naja";
                //not sure if this is really needed, but i have the feeling it is.
                redirect(URL("admin/transaction"));
            }
        }
    }
    public function checkReoccuring()
    {
        //TODO for future implementation of automated reoccuring system
    }

}
