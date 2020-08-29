<?php
//file: helpers.php 1.0.1
/*
 * NOTES:
 * testing of TheFramework\Helpers\
 * http://helpers.theframework.es
*/

//<editor-fold defaultstate="" desc="HELPERS">
/**
 * HELPERS
 **/
include(TFW_DOCROOTDS."vendor/autoload.php");

//<input type="date" id="datBirthdate" name="datBirthdate" as="date" data-options='{"useClearButton":true}'>

use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperDate;

$oLabel = new HelperLabel("datBirthdate","Birthdate","lblBirthdate");
$oDate = new HelperDate();
$oDate->set_id("datBirthdate");
$oDate->set_name("datBirthdate");
$oDate->show();

//</editor-fold>
