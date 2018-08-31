<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\SamsFactoryMethod 
 * @file SamsFactoryMethod .php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\Gof\FactorySM;

use DesignPatterns\Gof\FactorySM\AbstractFactoryMethod;

class SamsFactoryMethod extends AbstractFactoryMethod {
    private $context = "Sams";
    function makePHPBook($param) {
        $book = NULL;
        switch ($param) {
            case "us":
                $book = new SamsPHPBook;
            break;      
            case "other":
                $book = new OReillyPHPBook;
            break;
            case "otherother":
                $book = new VisualQuickstartPHPBook;
            break;
            default:
                $book = new SamsPHPBook;
            break;    
        }     
        return $book;
    }
}//SamsFactoryMethod