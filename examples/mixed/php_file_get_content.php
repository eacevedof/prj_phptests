<?php
/**
 * @file: php_file_get_content.php
 * @info: recuperacion de fichero blob
 */

include "vendor/Misc/FileContent/FromBlob/GetFileFromBlob.php";

use Misc\FileContent\FromBlob\GetFileFromBlob;

$r = GetFileFromBlob::getInstance()->__invoke();
