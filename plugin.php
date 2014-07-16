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
    function boot()
    {
        //TODO register classes in factory
    }

    function init()
    {
        //TODO define default lang. translation
        //TODO register lables, gambits, activity types and last action types
        //TODO include and override render functions
    }

    function setup($version)
    {
        //TODO use version to compare to old verisons and follow-up tasks
        //TODO manipulate db schema and init filesystem structues
    }

    function disable()
    {
        //TODO non-destructive cleanup tasks
    }

    function uninstall()
    {
        //TODO cleanup tasks like removing db tables
    }
}
