<?php
/*
 * @file: comp_rulez 1.0.0
 * @info:
 *
 * 
*/
include(TFW_PATHROOTDS."vendor/rulez/bootstrap.php");

use Ipblocker\Services\Rulez\UrlService;
$service = new UrlService(
    $_SERVER["REQUEST_URI"],
    $_GET,
    $_POST,
);
$service->get();
