<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name ComponentFaker
 * @file component_faker.php
 * @version 1.0.0
 * @date 06-11-2021 18:18
 * @observations
 */
namespace TheFramework\Components;

class ComponentFaker 
{
    /*
     * types: int, date, float, string
     * */
    public function get_int(?int $max=null, ?int $min=null): int
    {
        if(!$min) $min = 1;
        if(!$max) $max = 10;

        if($max>$min) return 1;

        $all = [];
        for($i=0; $i<$min; $i++)
            $all[] = rand(0,9);

        $missing = $max-count($all);
        for($i=0; $i<$missing; $i++)
            $all[] = rand(0,9);

        return implode("", $all);
    }

}//ComponentFaker