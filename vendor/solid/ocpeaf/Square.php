<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\Ocpeaf\Square
 * @file Square.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid\Ocpeaf;

use Solid\Ocpeaf\AbsShape;

class Square extends AbsShape
{
   private $side;
   
   //@Overide
   public function absm_draw() { echo "Draw Square";}
   
   //getter and setter methods:
   public function set_side(Integer $side){$this->side=$side;}
   public function get_side(){return $this->side;}
      
}//Square