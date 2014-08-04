<?php
//copyright 2014 at sexygaming.de

ET::$pluginInfo["ClanCash"] = array(
    "name"        => "ClanCash",
    "description" => "A plugin to manage money transactions for a community",
    "version"     => "1.0",
    "author"      => "Sallar Ahmadi-Pour",
    "authorEmail" => "sallar.ahmadipour@gmail.com",
    "authorURL"   => "http://sexygaming.de",
    //fancy
    "license"     => "CC BY-NC-SA 4.0",
    "dependencies" => array(
        "esoTalk"       => "1.0.0g4"
    )
);

class ETPlugin_ClanCash extends ETPlugin
{
    public function __construct($rootDirectory)
    {
        parent::__construct($rootDirectory);
        //TODO does this work? correctly for admincontroller?
        ETFactory::register("transactionModel", "TransactionModel", dirname(__FILE__)."/TransactionModel.class.php");
        ETFactory::registerController("transaction", "TransactionController", dirname(__FILE__)."/TransactionController.class.php");
        ETFactory::registerAdminController("transaction", "TransactionAdminController", dirname(__FILE__)."/admin/TransactionAdminController.class.php");
        ETFactory::register("transactionAdminModel", "TransactionAdminModel", dirname(__FILE__)."/admin/TransactionAdminModel.class.php");
        ETFactory::register("transactionAdminReoccuringModel", "TransactionAdminReoccuringModel", dirname(__FILE__)."/admin/TransactionAdminReoccuringModel.class.php");
    }
    public function handler_init($sender)
    {
        //adds the route to transaction controller in the top navigation menu
        //there must be a way with a handler...dont know it yet...
        if(ET::$session->userId){
            $sender->addToMenu("user", "transaction", "<a href='".URL("transaction")."'>".T("Kasse")."</a>", 1);
        }
    }
    public function handler_initAdmin($sender, $menu)
    {
        //adds the admin menu for administration of transactions
        $menu->add("transaction", "<a href='".URL("admin/transaction")."'><i class='icon-pencil'></i> ".T("Transactions")."</a>");
    }

    public function setup($oldVersion = "")
    {
        //TODO use version to compare to old verisons and follow-up tasks
        //db structure object
        $structure = ET::$database->structure();
        //if there is no table with name "eso_clancash"
        if(!$structure->table("eso_clancash")->exists())
        {
            //payment structure
            $structure->table("clancash")
                //id unsigned integer not null
                ->column("id", "int(11) unsigned", false)
                //id as primary key
                ->key("id", "primary")
                //memberId int not null
                ->column("memberId", "int(11) unsigned", false)
                //transactionDate date not null
                ->column("transactionDate", "date", false)
                //description of the transaction varchar not null
                ->column("description", "varchar(140)", false)
                //value of payment double -- dont give double a size like double(11)
                ->column("value", "double", false)
                //do it. -- dont mind the boolean, its fine there.
                ->exec(false);
            //reoccuring structure
            $structure->table("clancash_reocc")
                //id unsigned integer not null
                ->column("id", "int(11) unsigned", false)
                //id as primary key
                ->key("id", "primary")
                //memberId int not null
                ->column("memberId", "int(11) unsigned", false)
                //description of transaction
                ->column("description", "varchar(140)", false)
                //value of payment double
                ->column("value", "double", false)
                //date of next transaction
                ->column("nextTransactionDate", "date", false)
                //well you know, read it above...
                ->exec(false);
            return true;
        }
    }
    public function disable()
    {
        //maybe i'll do something in the future
        return true;
    }
    //function will drop the database when being uninstalled
    public function uninstall()
    {
        $structure = ET::$database->structure();
        //DROP TABLE "eso_clancash"
        $structure->table("eso_clancash")->drop();
        return true;
    }
}
