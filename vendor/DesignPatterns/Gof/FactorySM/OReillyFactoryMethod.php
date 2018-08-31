<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\OReillyFactoryMethod 
 * @file OReillyFactoryMethod .php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo [sourcemaking](https://sourcemaking.com/design_patterns/factory_method/php/1)
 */
namespace DesignPatterns\Gof\FactorySM;

use DesignPatterns\Gof\FactorySM\AbstractFactoryMethod;

class OReillyFactoryMethod extends AbstractFactoryMethod 
{
    private $context = "OReilly";

    function makePHPBook($sEditorial) 
    {
        $oBook = NULL;
        switch ($sEditorial) 
        {
            case "us":
                $oBook = new OReillyPHPBook;
            break;
            case "other":
                $oBook = new SamsPHPBook;
            break;
            default:
                $oBook = new OReillyPHPBook;
            break;        
        }
        return $oBook;
    }
}//OReillyFactoryMethod