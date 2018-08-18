<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\Customer
 * @file Customer.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid;

class Customer
{
   private $name;
   
   //getter and setter methods:
   public function set_name(String $name){$this->name=$name;}
   public function get_name(){return $this->name;}
   
   //this is one responsability
   public function store_customer(String $customerName)
   {
       //store customer into database
   }
   
   //this is another responsability
   public function generate_customer(String $customerName)
   {
       //generate a repport
   }
   
}//Customer