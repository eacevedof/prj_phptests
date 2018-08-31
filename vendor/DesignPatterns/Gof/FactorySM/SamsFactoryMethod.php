<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\SamsFactoryMethod 
 * @file SamsFactoryMethod .php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo [sourcemaking](https://sourcemaking.com/design_patterns/factory_method/php/1)
 */
namespace DesignPatterns\Gof\FactorySM;

use DesignPatterns\Gof\FactorySM\AbstractFactoryMethod;

//AbstractFactoryMethod aporta makePHPBook
class SamsFactoryMethod extends AbstractFactoryMethod 
{
    private $context = "Sams";
    function makePHPBook($sEditorial) 
    {
        $oBook = NULL;
        switch ($sEditorial) 
        {
            case "us":
                $oBook = new SamsPHPBook;
            break;      
            case "other":
                $oBook = new OReillyPHPBook;
            break;
            case "otherother":
                $oBook = new VisualQuickstartPHPBook;
            break;
            default:
                $oBook = new SamsPHPBook;
            break;    
        }//switch
        return $oBook;
    }
}//SamsFactoryMethod