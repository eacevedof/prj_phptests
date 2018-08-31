<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\Gof\FactorySM\VisualQuickstartPHPBook 
 * @file VisualQuickstartPHPBook.php
 * @version 1.0.0
 * @date 29-08-2018 13:59
 * @observations
 *  Ejemplo [sourcemaking](https://sourcemaking.com/design_patterns/factory_method/php/1)
 */
namespace DesignPatterns\Gof\FactorySM;

use DesignPatterns\Gof\FactorySM\AbstractPHPBook;

class VisualQuickstartPHPBook extends AbstractPHPBook {
    private $author;
    private $title;
    function __construct() {
      $this->author = 'Larry Ullman';
      $this->title  = 'PHP for the World Wide Web';
    }
    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
}//VisualQuickstartPHPBook