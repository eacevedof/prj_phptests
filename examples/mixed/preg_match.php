<?php
/* preg_match.php 1.0.0
 * 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sFile = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."examples/components/component_dts_auxrep.php";
$sContent = file_get_contents($sFile);
//extrae substring
$arMatches = [];
preg_match("/id=([0-9]+)\?/",$sContent, $arMatches);

//https://autohotkey.com/docs/misc/RegEx-QuickRef.htm
// (?<=...) and (?<!...) are positive and negative look-behinds (respectively) 
// because they look to the left of the current position rather than the right 
preg_match("/(?<!^)([A-Z])/","ComponentDtsxrepSuperBowl",$arMatches);

//buscan por la izquierda
//resultado:Component_Dtsxrep_Super_Bowl
$arMatches[] = preg_replace("/(?<!^)([A-Z])/","_$1","ComponentDtsxrepSuperBowl");
//resultado: _omponentDtsxrepSuperBowl
$arMatches[] = preg_replace("/(?<=^)([A-Z])/","_$1","ComponentDtsxrepSuperBowl");
echo "<pre>";
print_r($arMatches);
echo "<hr/>";
echo htmlentities($sContent);