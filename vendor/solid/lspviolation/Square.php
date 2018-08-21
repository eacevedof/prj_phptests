<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\LspViolation\Square
 * @file Square.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid\LspViolation;

use Solid\LspViolation\Rectangle;

class Square extends Rectangle
{
   
    //@Overide
    public function set_width(Integer $width)
    {
        parent::set_width($width);
        parent::set_height($width);
    }
    
    //@Overide
    public function set_height(Integer $height)
    {
        parent::set_width($height);
        parent::set_height($height);
    }
}//Square