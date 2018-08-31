<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\AbstractFactoryMethod
 * @file AbstractFactoryMethod.php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
*  Ejemplo [sourcemaking](https://sourcemaking.com/design_patterns/factory_method/php/1)
 */
namespace DesignPatterns\Gof\FactorySM;

abstract class AbstractFactoryMethod {
    abstract function makePHPBook($param);
}//AbstractFactoryMethod