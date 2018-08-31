<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\OReillyPHPBook 
 * @file OReillyPHPBook .php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo [sourcemaking](https://sourcemaking.com/design_patterns/factory_method/php/1)
 */
namespace DesignPatterns\Gof\FactorySM;

use DesignPatterns\Gof\FactorySM\AbstractPHPBook;

class OReillyPHPBook extends AbstractPHPBook {
    private $author;
    private $title;
    private static $oddOrEven = 'odd';
    function __construct() {
        //alternate between 2 books
        if ('odd' == self::$oddOrEven) {
            $this->author = 'Rasmus Lerdorf and Kevin Tatroe';
            $this->title  = 'Programming PHP';
            self::$oddOrEven = 'even';
        } else {
            $this->author = 'David Sklar and Adam Trachtenberg';
            $this->title  = 'PHP Cookbook'; 
            self::$oddOrEven = 'odd';
        }  
    }
    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
}//OReillyPHPBook