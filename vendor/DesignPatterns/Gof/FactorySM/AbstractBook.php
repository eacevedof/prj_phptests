<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\AbstractBook
 * @file AbstractBook.php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\Gof\FactorySM;

abstract class AbstractBook {
    abstract function getAuthor();
    abstract function getTitle();
}//AbstractBook