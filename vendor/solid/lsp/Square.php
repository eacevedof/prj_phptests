<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\Lsp\Square
 * @file Square.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid\Lsp;

use Solid\Lsp\IfShape;

class Square implements IfShape
{
    private $size;
    
    public function set_size(Integer $size){ $this->size = $size;}
    
    //@Overide
    public function get_area(){return $this->size*$this->size;}
   
}//Square