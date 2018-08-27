<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\ObserverPO
 * @file IfObserver.php
 * @version 1.1.0
 * @date 27-08-2018 12:56
 * @observations
 *  Ejemplo Post Office: [Post Office](https://www.youtube.com/watch?v=rWvXJo3OAzs)
 */
namespace DesignPatterns\ObserverPO;
use DesignPatterns\ObserverPO\IfSubject;

interface IfObserver 
{
    public function update(IfSubject $oIfSubj);
    
}//IfObserver