<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name Solid\Dip\DeliveryDriver
 * @file DeliveryDriver.php
 * @version 1.0.0
 * @date 18-08-2018 20:19
 * @observations
 *  SOLID en Java
 *  Tutorial: https://www.youtube.com/watch?v=j_ZnM8FJcmA
 *  Ejemplos: https://android.jlelse.eu/solid-principles-the-definitive-guide-75e30a284dea
 */
namespace Solid\Dip;

use Solid\Dip\IfDeliveryService;
use Solid\Dip\Product;


class DeliveryDriver implements IfDeliveryService 
{
    //@override
    public function deliver_product(Product $oProduct)
    {
        //deliver product...
    }
}//DeliveryDriver