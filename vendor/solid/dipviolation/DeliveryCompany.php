<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\DipViolation\DeliveryCompany
 * @file DeliveryCompany.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid\DipViolation;

use Solid\DipViolation\DeliveryDriver;

class DeliveryCompany 
{
    /*
     * Note that DeliveryCompany creates and uses DeliveryDriver concretions. 
     * Therefore DeliveryCompany which is a high-level class is dependent on a lower 
     * level class and this is a violation of Dependency Inversion Principle.
    */
    public function send_product(Product $oProduct)
    {
        $oDeliverDriver = new DeliveryDriver();
        $oDeliverDriver->deliver_product($oProduct);
    }
}//DeliveryCompany