<?php
/*
 * @file: comp_faker 1.0.0
 * @info:
 *
 * 
*/
include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");

use TheFramework\Components\ComponentFaker;
$component = new ComponentFaker();
$data["fake_int"] = $component->get_int();
$data["fake_int_max_4"] = $component->get_int(4);
$data["fake_int_max_15"] = $component->get_int(15);
$data["fake_int_min_3_max_15"] = $component->get_int(15,3);

$data["fake_float"] = $component->get_float();
$data["fake_date"] = $component->get_date();
$data["fake_time"] = $component->get_time();
$data["fake_date_time"] = $component->get_datetime();
$data["hash"] = $component->get_hash();
$data["word"] = $component->get_word();
$data["paragraph"] = $component->get_paragraph();
$data["email"] = $component->get_email();

pr($data,"faker result");


