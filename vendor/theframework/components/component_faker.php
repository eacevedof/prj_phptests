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
    public function get_int(?int $maxl=null, ?int $minl=null): int
    {
        if(!$minl) $minl = 1;
        if(!$maxl) $maxl = 10;

        if($maxl<$minl) return 1;

        $all = [];
        for($i=0; $i<$minl; $i++)
            $all[] = rand(0,9);

        $missing = $maxl-count($all);
        for($i=0; $i<$missing; $i++)
            $all[] = rand(0,9);

        return (int) implode("", $all);
    }

    public function get_rndint(int $min=0, int $max=9): int
    {
        if($max<$min) {
            $min = 0;
            $max = 9;
        }

        return rand($min, $max);
    }
    
    public function get_float(int $intl=2, int $decl=3): float
    {
        $float = [];
        for($i=0; $i<$intl; $i++)
            $float[] = $this->get_rndint();
        
        $float[] = ".";
        for($i=0; $i<$decl; $i++)
            $float[] = $this->get_rndint();
        
        return (float) implode("",$float);
    }
    

}//ComponentFaker