<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\ObserverPO
 * @file ClsMailBox.php
 * @version 1.1.0
 * @date 27-08-2018 12:56
 * @observations
 *  Ejemplo: [MailBox.java](https://youtu.be/rWvXJo3OAzs?t=267)
 */
namespace DesignPatterns\ObserverPO;

use DesignPatterns\ObserverPO\IfObserver;
use DesignPatterns\ObserverPO\IfSubject;

class ClsMailBox implements IfObserver
{
    private $sAddress;
    
    public function __construct(String $sAddress) 
    {
        $this->sAddress = $sAddress;
    }

    //@override
    public function update(IfSubject $oIfSubj) 
    {
        if($oIfSubj->get_address() == $this->sAddress)
            \dg::p("You have new mail in $this->sAddress");
        //else
            //\dg::p("NO MAIL for: $this->sAddress, mail goes to:".$oIfSubj->get_address());
    }//update

}//ClsMailBox