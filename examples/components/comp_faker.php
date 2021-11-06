<?php
/*
 * @file: comp_rulez 1.0.0
 * @info:
 *
 * 
*/
include(TFW_PATHROOTDS."vendor/rulez/bootstrap.php");

use TheFramework\Components\ComponentFaker;
$service = new ComponentFaker();
$data["fake_int"] = $service->get_int();
$data["fake_int_max_15"] = $service->get_int(15);
$data["fake_int_min_3_max_15"] = $service->get_int(15,3);

