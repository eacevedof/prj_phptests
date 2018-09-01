<?php
/**
 * @file:usererrorhandler_1and1.php
 */
error_reporting(0); 
$old_error_handler = set_error_handler("userErrorHandler"); 

function userErrorHandler($errno,$errmsg,$filename,$linenum,$vars) 
{ 
    //https://ayuda.1and1.es/hosting-c85122/scripting-y-programacion-c64780/php-c64788/logs-de-error-de-php-a694887.html
    $time=date("Ymd H:i:s");
    // Get the error type from the error number 
    $errortype = array (1 => "Error", 
    2 => "Warning", 
    4 => "Parsing Error", 
    8 => "Notice", 
    16 => "Core Error", 
    32 => "Core Warning", 
    64 => "Compile Error", 
    128 => "Compile Warning", 
    256 => "User Error", 
    512 => "User Warning", 
    1024 => "User Notice"); 
    $errlevel=$errortype[$errno]; 

    //$errfile=fopen("errors.csv","a"); 
    //fputs($errfile,"\"$time\",\"$filename:$linenum\",\"($errlevel) $errmsg\"\r\n"); 
    //fclose($errfile);
    
    $errfile=fopen("phperror.log","a"); 
    $sContent = "$time ($errlevel)\n $filename:$linenum\n $errmsg\n";
    //$sContent = "error $errlevel";
    fputs($errfile,$sContent); 
    fclose($errfile);

    if($errno!=2 && $errno!=8)
        die("A fatal error has occurred. Script execution has been aborted"); 
}//userErrorHandler