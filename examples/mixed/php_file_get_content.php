<?php
/**
 * @file: php_file_get_content.php
 * @info: recuperacion de fichero blob
 */

include "vendor/Misc/FileContent/FromBlob/GetFileFromBlob.php";
include "vendor/Misc/Shell/ShellExec.php";

use Misc\Shell\ShellExec;
use Misc\FileContent\FromBlob\GetFileFromBlob;

$shell = ShellExec::getInstance();
$urlRedir = "https://drive.google.com/file/d/1lP8sQ6I-r0C9W0Vn53RWtxopIj9OQwDo/view?usp=drive_link";
$shell->addCommand("curl -i $urlRedir");
//$shell->exec();
//$shelExec->printDebugCommand();

$blob = GetFileFromBlob::getInstance();
$blob->__invoke();
//$blob->withRedirect();

