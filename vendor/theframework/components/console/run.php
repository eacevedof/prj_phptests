<?php
//run.php 1.0.0
include("component_console.php");



$sAction = "process_files";
if(defined("STDIN"))
{
    //if(!empty($argv[1])) parse_str($argv[1],$_GET);
    if(isset($argv[1]))
        $sAction = $argv[1];
}

$oMain = new TheFramework\Components\Console();
$oMain->set_action($sAction);
//$oMain->run(1); //prod
$oMain->run(0); //local