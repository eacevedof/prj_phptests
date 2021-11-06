<?php
/*
 * @file: comp_faker 1.0.0
 * @info:
 *
 * 
*/
include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");

use TheFramework\Components\ComponentFaker;
$service = new ComponentFaker();
$data["fake_int"] = $service->get_int();
$data["fake_int_max_15"] = $service->get_int(15);
$data["fake_int_min_3_max_15"] = $service->get_int(15,3);

$data["fake_float"] = $service->get_float();
$data["fake_date"] = $service->get_date();
$data["fake_time"] = $service->get_time();
$data["fake_date_time"] = $service->get_datetime();

pr($data,"faker result");


