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

    }
    public function handler_init($sender)
    {

    }
    public function handler_initAdmin($sender)
    {

    }
    
    public function setup($oldVersion = "")
    {
        //TODO use version to compare to old verisons and follow-up tasks
        //TODO manipulate db schema and init filesystem structues
        $structure = ET::$database->structure();
        $structure->table("eso_clancash")
            ->column("id", "int(11) unsigned", false)
            ->column("")
        return true;
    }

    public function disable()
    {
        return true;
    }

    public function uninstall()
    {
        $structure = ET::$database->structure();
        //DROP TABLE "eso_clancash"
        $structure->table("eso_clancash")->drop();
        return true;
    }
}
