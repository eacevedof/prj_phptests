<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\Srp\Customer
 * @file Customer.php (Single Responsabiltiy)
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 *  Los otros metodos se eliminan. Se queda como una clase simple de atributos getters y setters
 */
namespace Solid\Srp;

class Customer
{
   private $name;
   
   //getter and setter methods:
   public function set_name(String $name){$this->name=$name;}
   public function get_name(){return $this->name;}
   
}//Customer