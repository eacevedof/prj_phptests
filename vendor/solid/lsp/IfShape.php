<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\Lsp\IfShape
 * @file IfShape.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 *  La clase ShapePrinter->draw se separa en (abstract)Shape->(abstract method)draw();
 */
namespace Solid\Lsp;

interface IfShape
{
    public function get_area();
    
}//Shape