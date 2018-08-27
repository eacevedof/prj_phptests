<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\ObserverPO
 * @file IfSubject.php
 * @version 1.0.0
 * @date 27-08-2018 12:56
 * @observations
 *  Ejemplo Post Office: [Post Office](https://www.youtube.com/watch?v=rWvXJo3OAzs)
 */
namespace DesignPatterns\ObserverPO;

use DesignPatterns\ObserverPO\IfObserver;

interface IfSubject 
{
    //subscribe
    public function add_observer(IfObserver $oIfObs);
    //unsubscribe
    public function remove_observer(IfObserver $oIfObs);
    //
    public function notify_observers();
    
}//IfSubject