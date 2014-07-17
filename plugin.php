<?php
//copyright 2014 sega|zero

ET::$pluginInfo["ClanCash"] = array(
    "name"        => "ClanCash",
    "description" => "A plugin for manage money transactions for a community",
    "version"     => "1.0",
    "author"      => "Sallar Ahmadi-Pour",
    "authorEmail" => "sallar.ahmadipour@gmail.com",
    "authorURL"   => "http://sexygaming.de",
    //fancy
    "license"     => "CC BY-NC-SA 4.0"
    "dependencies" => array(
        "esoTalk"       => "1.0.0g4"
    )
);

class ETPlugin_ClanCash extends ETPlugin
{
    public function __construct($rootDirectory)
    {
        parent::__construct($rootDirectory);
        ETFactory::register("transactionModel", "TransactionModel", dirname(__FILE__)."/TransactionModel.class.php");
        ETFactory::registerAdminController("transaction", "TransactionController", dirname(__FILE__)."/TransactionController.class.php");

    }
    public function handler_init($sender)
    {

    }
    public function handler_initAdmin($sender, $menu)
    {
        $menu->add("transaction", "<a href='".URL("admin/transaction")."'><i class='icon-pencil'></i> ".T("Transaction")."</a>");
    }

    public function setup($oldVersion = "")
    {
        //TODO use version to compare to old verisons and follow-up tasks
        //db structure object
        $structure = ET::$database->structure();
        //if there is no table with name "eso_clancash"
        if(!$structure->table("eso_clancash")->exists())
        {
            //create table structure with ...
            $structure->table("eso_clancash")
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
                //value of payment int
                ->column("value", "int(11)", false)
                //do it. -- dont mind the boolean, its fine there.
                ->exec(false);
            return true;
        }
    }
    public function disable()
    {
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
