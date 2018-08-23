<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\LspViolation\Liskov
 * @file Liskov.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid\LspViolation;

use Solid\LspViolation\Rectangle;

class Liskov
{
    public static function main()
    {
        $oRectangle = new Rectangle();
        $oRectangle->set_height(2);
        $oRectangle->set_height(5);
        
        if($oRectangle->get_area()==10)
        {
            echo $oRectangle->get_area();
        }
    }
}//Liskov