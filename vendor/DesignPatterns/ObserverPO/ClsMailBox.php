<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\ObserverPO
 * @file ClsMailBox.php
 * @version 1.0.0
 * @date 27-08-2018 12:56
 * @observations
 *  Ejemplo Post Office: [Post Office](https://www.youtube.com/watch?v=rWvXJo3OAzs)
 */
namespace DesignPatterns\ObserverPO;

use DesignPatterns\ObserverPO\IfObserver;

class ClsMailBox implements IfObserver
{
    private $sAddress;
    
    public function __construct(String $sAddress) 
    {
        $this->sAddress = $sAddress;
    }

    //@override
    public function update() 
    {
        \dg::p("You have new mail in $this->sAddress");
    }//update

}//ClsMailBox