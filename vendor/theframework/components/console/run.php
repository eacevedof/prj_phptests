<?php
//run.php 2.0.0
include("component_console.php");

function run_m($sText){echo $sText."\n";}

run_m("running run.php 2.0.0");
/*
php run.php $argv[1]                $argv[2]                    $argv[3]    $argv[4..n]
php run.php <path_file_to_include>  <class_name_case_sensitive> <method>    <rest-of-arguments>
*/
if(defined("STDIN"))
{
    run_m("defined STDIN");
    try 
    {
        $oRunner = new TheFramework\Components\Console\ComponentConsole($argv);
        $oRunner->set_pathclass($argv[1]);
        $oRunner->set_classname($argv[2]);
        $oRunner->set_method($argv[3]);
        $oRunner->run();        
    } 
    catch (Exception $oEx) 
    {
        $sMessage= "run.php Exception:{$oEx->getMessage()}";
        run_m($sMessage);
    }
}
else
{
    run_m("Not console called");
}

