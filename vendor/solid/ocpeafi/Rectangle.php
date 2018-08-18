<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\Ocpeafi\Rectangle
 * @file Rectangle.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid\Ocpeafi;

//clase abstracta 
use Solid\Ocpeafi\IfShape;

class Rectangle implements IfShape
{
   private $width;
   private $height;
   
   //@Overide
   public function ifm_draw() { echo "Draw Rectangle";}
   
   //getter and setter methods:
   public function set_width(Integer $width){$this->width=$width;}
   public function get_width(){return $this->width;}
   
   public function set_height(Integer $height){$this->height=$height;}
   public function get_height(){return $this->height;}
   
}//Rectangle