<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\OReillyFactoryMethod 
 * @file OReillyFactoryMethod .php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\Gof\FactorySM;

use DesignPatterns\Gof\FactorySM\AbstractFactoryMethod;

class OReillyFactoryMethod extends AbstractFactoryMethod {
    private $context = "OReilly";  
    function makePHPBook($param) {
    $book = NULL;   
        switch ($param) {
            case "us":
                $book = new OReillyPHPBook;
            break;
            case "other":
                $book = new SamsPHPBook;
            break;
            default:
                $book = new OReillyPHPBook;
            break;        
        }     
    return $book;
    }
}//OReillyFactoryMethod