<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\SamsPHPBook 
 * @file SamsPHPBook .php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo [sourcemaking](https://sourcemaking.com/design_patterns/factory_method/php/1)
 */
namespace DesignPatterns\Gof\FactorySM;

use DesignPatterns\Gof\FactorySM\AbstractPHPBook;

class SamsPHPBook extends AbstractPHPBook 
{
    private $author;
    private $title;

    function __construct() 
    {
        //alternate randomly between 2 books
        mt_srand((double)microtime()*10000000);
        $iRndm = mt_rand(0,1);      
 
        if (1 > $iRndm) 
        {
            $this->author = "George Schlossnagle";
            $this->title  = "Advanced PHP Programming";
        } 
        else 
        {
            $this->author = "Christian Wenz";
            $this->title  = "PHP Phrasebook"; 
        }  
    }//_construct()

    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
}//SamsPHPBook